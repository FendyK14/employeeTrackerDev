<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Index
    public function index(Request $request)
    {
        // header
        $header = ['No', 'Project Name', 'Start Date', 'End Date', 'Group Name', 'Status', 'Action'];

        // Get Data
        $query['search'] = $request->get('search');
        $query['date'] = $request->get('date');

        // cek group
        $auth = Auth::guard('employee')->user()->employeeId;

        $projects = Project::whereHas('groups.employees', function ($query) use ($auth) {
            $query->where('employees.employeeId', $auth);
        })
            ->where('projectName', 'LIKE', '%' . $query['search'] . '%')
            ->when($query['date'], function ($queryBuilder) use ($query) {
                $month = Carbon::parse($query['date'])->format('m');
                $year = Carbon::parse($query['date'])->format('Y');
                $queryBuilder->whereMonth('startDate', '=', $month)->whereYear('startDate', '=', $year);
            })
            ->paginate(10)
            ->withQueryString();

        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // Return view ke halaman project
        return view('content.project.projectList', compact('header', 'projects'));
    }

    // Store
    public function index_add()
    {
        // cek group
        $auth = Auth::guard('employee')->user()->employeeId;

        $groups = Group::whereDoesntHave('projects')
            ->whereHas('employees', function ($query) use ($auth) {
                $query->where('employees.employeeId', $auth);
            })->get();

        return view('content.project.add', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'projectName' => 'required',
            'startDate' => 'required|date|after:1900/01/01|before:endDate',
            'endDate' => 'required|date|after:startDate',
            'groupId' => 'required',
        ]);

        Project::create([
            'projectName' => $request->projectName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'groupId' => $request->groupId,
            'status' => $request->status
        ]);
        return redirect()->route('List Project')->with('success', 'Project created successfully!');
    }

    // Update
    public function index_update($id)
    {
        // Cari id projectt
        $project = Project::find($id);

        // cek group
        $auth = Auth::guard('employee')->user()->employeeId;

        $groups = Group::whereDoesntHave('projects')
            ->whereHas('employees', function ($query) use ($auth) {
                $query->where('employees.employeeId', $auth);
            })->orWhere('groupId', $project->groupId)->get();

        // dd($groups->toSql());
        // // Query groups
        // $groups = Group::whereDoesntHave('projects')
        //     ->orWhere('groupId', $project->groupId)
        //     ->get();

        // Return view jika id berhasil ditemukan
        return view('content.project.edit', compact('project', 'groups'));
    }

    public function update(Request $request, $id)
    {
        // Validasi sebelum melakukan update
        $request->validate([
            'projectName' => 'required',
            'startDate' => 'required|date|after:1900/01/01|before:endDate',
            'endDate' => 'required|date|after:startDate',
            'groupId' => 'required'
        ]);

        // Cari project berdasarkan id
        $project = Project::find($id);

        // jika id ditemukan lakukan update pada project
        $project->fill([
            'projectName' => $request->projectName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'groupId' => $request->groupId,
            'status' => $request->status
        ]);

        // Simpan perubahan
        $project->save();

        return redirect()->route('List Project')->with('success', 'Project updated successfully!');
    }

    // Delete Project
    public function destroy($id)
    {
        $project = project::findOrFail($id); // Dapatkan objek project berdasarkan $id
        $projectName = $project->projectName; // Dapatkan projectName dari objek project

        $project->delete(); // Hapus project dari basis data
        return redirect()->route('List Project')->with('success', "$projectName deleted successfully!");
    }
}
