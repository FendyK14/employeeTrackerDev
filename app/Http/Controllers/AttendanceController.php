<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show data
    public function index(Request $request)
    {

        // Mendapatkan ID employee saat ini
        $auth = Auth::guard('employee')->user();
        $employeeId = $auth->employeeId;

        // Header tabel
        $header = ['No', 'Clock In', 'Clock Out', 'Work Type', 'Status', 'Image'];

        if ($auth->positionId == 1) {
            $header = ['No', 'Employee Name', 'Clock In', 'Clock Out', 'Work Type', 'Status', 'Image', 'Action'];
        }

        // Mendapatkan query pencarian dari request
        $query['search'] = $request->get('search');
        $query['date'] = $request->get('date');

        $attendances = Attendance::with('employees')
            ->where(function ($queryBuilder) use ($query, $auth, $employeeId) {
                if ($auth->positionId == 1) {
                    // Jika posisi adalah HR (positionId = 1)
                    if ($query['search']) {
                        $queryBuilder->whereHas('employees', function ($subQuery) use ($query) {
                            $subQuery->where('employeeName', 'like', '%' . $query['search'] . '%');
                        });
                    }
                    else if ($query['date']) {
                        $queryBuilder->whereDate('clockIn', $query['date']);
                    }
                } else {
                    $queryBuilder->where('employeeId', $employeeId);
                    if ($query['date']) {
                        $queryBuilder->whereDate('clockIn', $query['date']);
                    }
                }
            })->orderBy('clockIn', 'desc')->paginate(10)->withQueryString();

        return view('content.attendance.attendanceList', compact('header', 'attendances', 'query'));
    }

    // Check In attendance
    public function checkIn(Request $request)
    {
        $request->validate([
            'workType' => 'required'
        ]);

        $employeeId = Auth::guard('employee')->user()->employeeId;
        $today = Carbon::today();

        // Check if employee has already checked in today
        $existingAttendance = Attendance::where('employeeId', $employeeId)
            ->whereDate('clockIn', $today)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('warning', 'You have already checked in today!');
        }

        // create new attendance
        $attendance = new Attendance;
        $attendance->employeeId = $employeeId;
        $attendance->clockIn = Carbon::now();
        $attendance->clockOut = null;
        $attendance->workType = $request->input('workType');
        $attendance->image = '-';
        $attendance->status = 'Present';

        if ($attendance->workType == 'WFH') {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $path = $request->file('file')->store('images', 'public');
                $attendance->image = $path;
            } else {
                return redirect()->back()->with('warning', 'Image needed');
            }
        }

        $attendance->save();

        return redirect()->back()->with('success', 'Check-in successful!');
    }

    // Check Out attendance
    public function checkOut(Request $request)
    {
        $employeeId = Auth::guard('employee')->user()->employeeId;
        $today = Carbon::today();

        $attendance = Attendance::where('employeeId', $employeeId)
            ->whereDate('clockIn', $today)
            ->whereNull('clockOut')
            ->orderBy('clockIn', 'desc')
            ->first();

        if ($attendance) {
            $attendance->clockOut = Carbon::now();
            $attendance->status = 'Completed';
            $attendance->save();

            return redirect()->back()->with('success', 'Check-out successful!');
        }

        return redirect()->back()->with('error', 'No check-in record found for today!');
    }

    // Index Add attendance
    public function index_add()
    {
        $employees = Employee::all();
        return view('content.attendance.attendance-add', compact('employees'));
    }

    // store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employeeId' => 'required|exists:employees,employeeId',
            'clockIn' => 'required|date',
            'clockOut' => 'nullable|date',
            'workType' => 'required',
            'status' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        $imagePath = "-";
        // clock in & clock out required if status = Completed
        if ($request->status == 'Completed') {
            if (empty($request->clockIn) || empty($request->clockOut)) {
                return redirect()->back()->with('warning', 'Clock In & Clock Out is required when status is Completed');
            }
        }
        // check has image if worktype = WFH
        if ($request->workType == 'WFH') {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('images', 'public');
            } else {
                return redirect()->back()->with('warning', 'Image needed');
            }
        }

        // create new attendance
        Attendance::create([
            'employeeId' => $validatedData['employeeId'],
            'clockIn' => $validatedData['clockIn'],
            'clockOut' => $validatedData['clockOut'],
            'workType' => $validatedData['workType'],
            'status' => $validatedData['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('Attendance')->with('success', 'Attendance added successfully.');
    }

    // Index Edit
    public function index_update($id)
    {
        $data = Attendance::where('attendanceId', '=', $id)->first();
        return view('content.attendance.attendance-edit', compact('data'));
    }

    // Update attendance
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'clockIn' => 'required|date',
            'clockOut' => 'nullable|date',
            'workType' => 'required',
            'status' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        if ($request->status == 'Completed') {
            if (empty($request->clockIn) || empty($request->clockOut)) {
                return redirect()->back()->with('warning', 'Clock In & Clock Out are required when status is Completed');
            }
        }

        $attendance = Attendance::find($id);

        $imagePath = $attendance->image;
        if ($request->workType == 'WFH') {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('images', 'public');
            }
        }

        $attendance->update([
            'clockIn' => $validatedData['clockIn'],
            'clockOut' => $validatedData['clockOut'],
            'workType' => $validatedData['workType'],
            'status' => $validatedData['status'],
            'image' => $imagePath,
        ]);

        return redirect()->route('Attendance')->with('success', 'Attendance updated successfully.');
    }
}
