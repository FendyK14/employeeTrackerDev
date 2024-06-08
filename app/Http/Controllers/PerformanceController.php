<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Performance;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PerformanceController extends Controller
{
    // index
    public function index(Request $request)
    {
        $auth = Auth::guard('employee')->user();
        $employeeId = $auth->employeeId;
        $header = ['No', 'Evaluation Date', 'Description', 'Notes', 'Action'];

        if ($auth->positionId == 1) {
            $header = ['No', 'Employee Name', 'Evaluation Date', 'Description', 'Status', 'Notes', 'Action'];
        }

        // Mendapatkan query pencarian dari request
        $query['search'] = $request->get('search');
        $query['date'] = $request->get('date');

        $performances = Performance::with('employees')
            ->where(function ($queryBuilder) use ($query, $auth, $employeeId) {
                if ($auth->positionId == 1) {
                    if ($query['search']) {
                        $queryBuilder->whereHas('employees', function ($subQuery) use ($query) {
                            $subQuery->where('employeeName', 'like', '%' . $query['search'] . '%');
                        });
                    } else if ($query['date']) {
                        $date = explode('-', $query['date']);
                        $queryBuilder->whereMonth('evaluationDate', $date[1])->whereYear('evaluationDate', $date[0]);
                    }
                } else {
                    $queryBuilder->where('employeeId', $employeeId)->where('status', 'Completed');
                    if ($query['date']) {
                        $date = explode('-', $query['date']);
                        $queryBuilder->whereMonth('evaluationDate', $date[1])->whereYear('evaluationDate', $date[0]);
                    }
                }
            })->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('content.report.reportList', compact('header', 'performances', 'query'));
    }

    // create
    public function index_add(Request $request)
    {
        $employees = Employee::where('positionId', '!=', 1)->get();
        $header = ['No', 'KPIs Indicator', 'Score'];

        $kpis = [
            ['id' => 1, 'indicator' => 'Attendance'],
            ['id' => 2, 'indicator' => 'Communication'],
            ['id' => 3, 'indicator' => 'Responsibility'],
            ['id' => 4, 'indicator' => 'Quality of Work'],
            ['id' => 5, 'indicator' => 'Collaboration'],
        ];

        return view('content.report.report-add', compact('employees', 'kpis', 'header'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId' => 'exists:employees,employeeId',
            'evaluationDate' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string|max:100',
            'status' => 'required|string|in:Pending,Cancelled,Completed',
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0|max:100',
        ]);

        // validasi existing
        $existingReport = Performance::where('employeeId', $request->employeeId)
            ->where('evaluationDate', $request->evaluationDate)->first();

        if ($existingReport) {
            return redirect()->back()->withErrors(['error' => 'Report for this employee already exists.']);
        }

        Performance::create([
            'employeeId' => $request->employeeId,
            'evaluationDate' => $request->evaluationDate,
            'description' => $request->description ?? '-',
            'notes' => $request->notes ?? '-',
            'status' => $request->status,
            'attendanceScore' => $request->scores[1] ?? 0,
            'communicationScore' => $request->scores[2] ?? 0,
            'responsibilityScore' => $request->scores[3] ?? 0,
            'qualityWorkScore' => $request->scores[4] ?? 0,
            'collaborationScore' => $request->scores[5] ?? 0,
        ]);

        return redirect()->route('List Report')->with('success', 'Report added successfully.');
    }

    // update
    public function index_update($id)
    {
        $performance = Performance::findOrFail($id);
        $evaluationDate = Carbon::parse($performance->evaluationDate);

        $header = ['No', 'KPIs Indicator', 'Score'];

        $kpis = [
            ['id' => 1, 'indicator' => 'Attendance'],
            ['id' => 2, 'indicator' => 'Communication'],
            ['id' => 3, 'indicator' => 'Responsibility'],
            ['id' => 4, 'indicator' => 'Quality of Work'],
            ['id' => 5, 'indicator' => 'Collaboration'],
        ];

        // Prepare scores
        $scores = [
            1 => $performance->attendanceScore,
            2 => $performance->communicationScore,
            3 => $performance->responsibilityScore,
            4 => $performance->qualityWorkScore,
            5 => $performance->collaborationScore,
        ];

        return view('content.report.report-edit', compact('performance', 'kpis', 'header', 'scores', 'evaluationDate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable|string',
            'notes' => 'nullable|string|max:100',
            'status' => 'required|string|in:Pending,Cancelled,Completed',
            'scores' => 'required|array',
            'scores.*' => 'required|integer|min:0|max:100',
        ]);

        $performance = Performance::findOrFail($id);

        // validasi existing has status 'Completed'
        if ($performance->status == 'Completed' || $performance->status == 'Cancelled') {
            return redirect()->back()->withErrors(['error' => 'Cannot edit report with status ' . $performance->status . '.']);
        }

        $performance->update([
            'description' => $request->description ?? '-',
            'notes' => $request->notes ?? '-',
            'status' => $request->status,
            'attendanceScore' => $request->scores[1] ?? 0,
            'communicationScore' => $request->scores[2] ?? 0,
            'responsibilityScore' => $request->scores[3] ?? 0,
            'qualityWorkScore' => $request->scores[4] ?? 0,
            'collaborationScore' => $request->scores[5] ?? 0,
        ]);

        return redirect()->route('List Report')->with('success', 'Report updated successfully.');
    }

    // destroy
    public function destroy($id)
    {
        $reports = Performance::findOrFail($id);
        $employeeName = $reports->employees->employeeName;

        if ($reports->status != 'Cancelled') {
            return redirect()->back()->withErrors(['error' => 'Cannot delete report with status ' . $reports->status . '.']);
        }

        $reports->delete();
        return redirect()->route('List Report')->with('success', "Report $employeeName deleted Successfully!");
    }

    // Download PDF
    public function downloadPdf($id)
    {
        // user
        $auth = Auth::guard('employee')->user();

        $performances = Performance::findOrFail($id);
        $employeeName = $performances->employees->employeeName;
        $employeeId = $performances->employees->employeeId;

        // view data group dengan project
        $groups = Group::whereHas('employees', function ($query) use ($employeeId) {
            $query->where('employees.employeeId', $employeeId);
        })->with(['employees' => function ($query) {
            $query->wherePivot('isLeader', true);
        }, 'projects'])->get();

        // checking who accessing
        if ($auth->positionId != 1) {
            if ($auth->employeeId != $performances->employees->employeeId) {
                return redirect('/dashboard')->with('error', 'You are not authorized to view this page.');
            }
        }

        // Checking records status
        if ($performances->status != 'Completed') {
            return redirect()->back()->withErrors(['error' => 'No Report']);
        }

        // Generate PDF
        $pdf = PDF::loadView('report-template.report', compact('performances', 'employeeName', 'groups'));

        // Download the PDF directly
        // return $pdf->download('performance_report_' . $employeeName . '_' . $performances->evaluationDate . '.pdf');

        // Return PDF to open in new tab
        return $pdf->stream('performance_report_' . $employeeName . '_' . $performances->evaluationDate . '.pdf');
    }
}
