<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // view data berdasarkan company
        $auth = Auth::guard('employee')->user();
        $companyId = $auth->companyId;

        // Query data berdasarkan company
        // $employees = Employee::where('companyId', $auth)->paginate(10)->withQueryString();

        // view data attendance
        $attendances = Attendance::with('employees')->orderBy('clockIn', 'desc')->paginate(10)->withQueryString();

        // view data project all employee
        $employees = Employee::with(['groups.projects'])
            ->whereHas('groups.projects')
            ->orderBy('employeeName')
            ->get();

        $allProjects = [];
        $employeeProjects = [];
        foreach ($employees as $employee) {
            foreach ($employee->groups as $group) {
                if ($group->projects) {
                    $employeeProjects[] = [
                        'employeeName' => $employee->employeeName,
                        'projectName' => $group->projects->projectName,
                        'startDate' => $group->projects->startDate,
                        'endDate' => $group->projects->endDate,
                        'status' => $group->projects->status,
                    ];
                }
            }
        }
        // pagination for this
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($employeeProjects, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($employeeProjects), $perPage);

        // view data project each employee
        $projects = Project::whereHas('groups', function ($query) use ($auth) {
            $query->whereHas('employees', function ($subQuery) use ($auth) {
                $subQuery->where('employees.employeeId', $auth->employeeId);
            });
        })->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // view data activity all employee
        $allActivities = Activity::with('employees')->orderBy('created_at', 'desc')
            ->paginate(10)->withQueryString();

        // view data activity each employee
        $activities = Activity::where('employeeId', $auth->employeeId)->orderBy('created_at', 'desc')
            ->paginate(10)->withQueryString();

        // view data group dengan project
        $groups = Group::whereHas('employees', function ($query) use ($auth) {
            $query->where('employees.employeeId', $auth->employeeId);
        })->with(['employees' => function ($query) {
            $query->wherePivot('isLeader', true);
        }])->paginate(10)->withQueryString();

        // auth position
        if ($auth->positionId == 1) {
            // header table
            $headerFirstTab = ['No', 'Employee Name', 'Clock In', 'Clock Out', 'Work Type', 'Status', 'Image'];
            $headerSecondTab = ['No', 'Employee Name', 'Project Name', 'Start Date', 'End Date', 'Status'];
            $headerThirdTab = ['No', 'Employee Name', 'Activity', 'Sub Activity', 'Start Date', 'End Date', 'Description', 'Priority', 'Status'];

            // records
            $recordsFirstTab = $attendances;
            $recordsSecondTab = $paginatedItems;
            $recordsThirdTab = $allActivities;
        } else {
            // header table
            $headerFirstTab = ['No', 'Project Name', 'Start Date', 'End Date', 'Status'];
            $headerSecondTab = ['No', 'Group', 'Activity', 'Sub Activity', 'Start Date', 'End Date', 'Description', 'Priority', 'Status'];
            $headerThirdTab = ['No', 'Group Name', 'Leader', 'Project Name', 'Status'];

            // records
            $recordsFirstTab = $projects;
            $recordsSecondTab = $activities;
            $recordsThirdTab = $groups;
        }


        return view('content.dashboard.dashboard', compact('headerFirstTab', 'headerSecondTab', 'headerThirdTab', 'employees', 'recordsFirstTab', 'recordsSecondTab', 'recordsThirdTab'));
    }
}
