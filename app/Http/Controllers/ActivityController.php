<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Group;
use App\Models\Project;
use App\Models\Sub_Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ActivityController extends Controller
{
    // Index Group
    public function index_group(Request $request)
    {
        // Mendapatkan ID pegawai yang sedang login
        $employeeId = Auth::guard('employee')->user()->employeeId;
        // Search
        $query['search'] = $request->get('search');
        // Query group berdasarkan $query
        $groups = Group::where('groupName', 'LIKE', '%' . $query['search'] . '%')
            ->whereHas('employees', function ($query) use ($employeeId) {
                $query->where('employees.employeeId', $employeeId); // Memastikan pengguna adalah pemilik grup
            })->with('employees')->paginate(9)->withQueryString();

        // Return view ketika success
        return view('content.activity.group.groupActivity', compact('groups', 'query'));
    }

    // Index Detail Activity Group
    public function index_activity_group($id)
    {
        // Ambil Nama Project berdasarkan Id
        $project = Group::find($id);
        $projectId = $project->projects ? $project->projects->projectId : "";

        // header
        $header = ['No', 'Employee', 'Activity', 'Sub Activity', 'Start Date', 'End Date', 'Description', 'Priority', 'Status', 'Action'];

        // Get Activity
        $activity = Activity::where('projectId', $projectId)->paginate(10)->withQueryString();

        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('content.activity.group.activitiesList', compact('project', 'header', 'activity'));
    }

    // Store
    public function index_add_group($id)
    {
        // cek id group
        $group = Group::find($id);
        // Cek employee di group berdasarkan idnya

        $subActivity = Sub_Activity::with('activities')->get();

        return view('content.activity.group.add', compact('group', 'subActivity'));
    }

    public function store_activity(Request $request, $id)
    {
        $request->validate([
            'activityName' => 'required',
            'startDate' => 'required|date|after:01/01/1900',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'priority' => 'required',
            'employeeId' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'subActivityId' => 'nullable'
        ]);

        // Cek group
        $project = Group::find($id);

        // Ambil id projectnya
        $projects = $project->projects->projectId;

        // dd($projectId);
        Activity::create([
            'activityName' => $request->activityName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'priority' => $request->priority,
            'employeeId' => $request->employeeId,
            'description' => $request->description,
            'status' => $request->status,
            'projectId' => $projects,
            'subActivityId' => $request->subActivityId
        ]);

        return redirect()->route('Group Activities', ['id' => $id])->with('success', 'Activity created successfully!');
    }

    // Delete
    public function destroy($groupId, $activityId)
    {
        $activity = Activity::findOrFail($activityId); // Dapatkan objek activity berdasarkan $id
        $activityName = $activity->activityName; // Dapatkan aactivityName dari objek activity

        $activity->delete(); // Hapus activity$activity dari basis data
        return redirect()->route('Group Activities', ['id' => $groupId])->with('success', "$activityName deleted successfully!");
    }

    // Edit
    public function index_edit_group($groupId, $activityId)
    {
        // cek id group
        $group = Group::find($groupId);
        // Cek activity di group berdasarkan idnya
        $activity = Activity::find($activityId);
        // get all sub activity
        $subActivity = Sub_Activity::with('activities')->get();
        return view('content.activity.group.edit', compact('subActivity', 'group', 'activity'));
    }

    public function update_activity(Request $request, $groupId, $activityId)
    {
        // Validasi sebelum udpate
        $request->validate([
            'activityName' => 'required',
            'startDate' => 'required|date|after:01/01/1900',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'priority' => 'required',
            'employeeId' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'subActivityId' => 'nullable'
        ]);

        // Cek group
        $project = Group::find($groupId);

        // Ambil id projectnya
        $projects = $project->projects->projectId;

        // Cek activity berdasarkan idnya
        $activity = Activity::find($activityId);
        // Update jika sudah berhasil semua
        $activity->fill([
            'activityName' => $request->activityName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'priority' => $request->priority,
            'employeeId' => $request->employeeId,
            'description' => $request->description,
            'status' => $request->status,
            'projectId' => $projects,
            'subActivityId' => $request->subActivityId
        ]);

        $activity->save();

        return redirect()->route('Group Activities', ['id' => $groupId])->with('success', 'Activity updated successfully!');
    }

    // Index Activity
    public function index(Request $request)
    {
        // Search
        $query['search'] = $request->get('search');

        // header
        $header = ['No', 'Group', 'Activity', 'Sub Activity', 'Start Date', 'End Date', 'Description', 'Priority', 'Status', 'Action'];

        // cek auth
        $auth = Auth::guard('employee')->user()->employeeId;
        $activity = Activity::where('activityName', 'LIKE', '%' . $query['search'] . '%')->where('employeeId', $auth)->paginate(10)->withQueryString();

        // Return view ketika success
        return view('content.activity.your.yourActivity', compact('activity', 'header'));
    }

    // Index edit
    public function index_edit($id)
    {
        // cek id group
        $activity = Activity::find($id);
        $group = $activity->projects->groups;

        // get all sub activity
        $subActivity = Sub_Activity::with('activities')->get();
        return view('content.activity.your.edit', compact('subActivity', 'group', 'activity'));
    }

    public function update(Request $request, $id)
    {
        // Validasi sebelum udpate
        $request->validate([
            'activityName' => 'required',
            'startDate' => 'required|date|after:01/01/1900',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'priority' => 'required',
            'employeeId' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'subActivityId' => 'nullable'
        ]);

        // cek id activity untuk mendapatkan projectId nya
        $activity = Activity::find($id);
        $projects = $activity->projectId;

        // Update jika sudah berhasil semua
        $activity->fill([
            'activityName' => $request->activityName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'priority' => $request->priority,
            'employeeId' => $request->employeeId,
            'description' => $request->description,
            'status' => $request->status,
            'projectId' => $projects,
            'subActivityId' => $request->subActivityId
        ]);

        // Save activity jika semua sudah divalidasi
        $activity->save();

        return redirect()->route('Your activity')->with('success', 'Activity updated successfully!');
    }
}
