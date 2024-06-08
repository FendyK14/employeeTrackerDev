<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubActivityController;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home

//login
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'index'])->name('Login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('Authenticate');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('Logout');

// Register company
Route::get('/register/company', [AuthController::class, 'index_register_company'])->name('RegisterCompany');
Route::post('/register/company', [AuthController::class, 'register_company'])->name('AuthenticateCompany');

// Register user
Route::get('/register/user', [AuthController::class, 'index_register_user'])->name('RegisterUser');
Route::post('/register/user', [AuthController::class, 'register_user'])->name('AuthenticateUser');

Route::middleware('setDB')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

    // Employee Data
    Route::get('/employee', [EmployeeController::class, 'index'])->name('List Employee');

    // Add Employee
    Route::get('/employee/add', [EmployeeController::class, 'index_add'])->name('Add Employee');
    Route::post('/employee/add', [EmployeeController::class, 'store'])->name('Added Employee');

    // Import
    Route::post('/employee/import', [EmployeeController::class, 'import'])->name('Import');

    // Edit Employee
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'index_update'])->name('Edit Employee');
    Route::patch('/employee/{id}/edit', [EmployeeController::class, 'update'])->name('Edited Employee');

    // Delete Employee
    Route::delete('/employee/{id}/delete', [EmployeeController::class, 'destroy'])->name('Delete Employee');

    // Company Profile
    Route::get('/profile/{id}/company', [CompanyController::class, 'index'])->name('Company Profile');
    Route::patch('/profile/{id}/company', [CompanyController::class, 'update'])->name('Edit Company Profile');

    // Position Data
    Route::get('/position', [PositionController::class, 'index'])->name('List Position');

    // Add Position
    Route::get('/position/add', [PositionController::class, 'index_add'])->name('Add Position');
    Route::post('/position/add', [PositionController::class, 'store'])->name('Added Position');

    // Edit Position
    Route::get('/position/{id}/edit', [PositionController::class, 'index_update'])->name('Edit Position');
    Route::patch('/position/{id}/edit', [PositionController::class, 'update'])->name('Edited Position');

    // User Profile
    Route::get('/profile/{id}/user', [EmployeeController::class, 'index_profile'])->name('User Profile');
    Route::patch('/profile/{id}/user', [EmployeeController::class, 'update_profile'])->name('Edit User Profile');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('Attendance');

    // Check In Attendance
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('Attendance CheckIn');
    // Check Out Attendance
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('Attendance CheckOut');
    // Add attendance by HR
    Route::get('/attendance/add', [AttendanceController::class, 'index_add'])->name('Add Attendance');
    Route::post('/attendance/add', [AttendanceController::class, 'store'])->name('Added Attendance');
    // Edit attendance by HR
    Route::get('/attendance/{id}/edit', [AttendanceController::class, 'index_update'])->name('Edit Attendance');
    Route::post('/attendance/{id}/edit', [AttendanceController::class, 'update'])->name('Edited Attendance');

    Route::patch('/profile/{id}/password', [EmployeeController::class, 'update_password'])->name('Edit User Password');

    // Group Data
    Route::get('/groups', [GroupController::class, 'index'])->name('Group List');

    // Add Group
    Route::get('/groups/add', [GroupController::class, 'index_add'])->name('Add Group');
    Route::post('/groups/add', [GroupController::class, 'store'])->name('Added Group');

    // Detail Group
    Route::get('/groups/{id}/detail', [GroupController::class, 'index_detail'])->name('Group Detail');

    // Delete Group
    Route::get('/groups/{id}/delete', [GroupController::class, 'destroy'])->name('Delete Group');

    // Add Member
    Route::get('/member/{id}/add', [GroupController::class, 'index_member'])->name('Add Member');
    Route::post('member/{id}/add', [GroupController::class, 'store_member'])->name('Added Member');

    // Edit Group
    Route::get('/groups/{id}/edit', [GroupController::class, 'index_update'])->name('Edit Group');
    Route::patch('/groups/{id}/edit', [GroupController::class, 'update'])->name('Edited Group');

    // Delete Member
    Route::delete('/groups/{groupId}/member/{employeeId}/delete', [GroupController::class, 'destroy_member'])->name('Delete Member');

    // Project
    Route::get('/project', [ProjectController::class, 'index'])->name('List Project');

    // Add Project
    Route::get('/project/add', [ProjectController::class, 'index_add'])->name('Added Project');
    Route::post('/project/add', [ProjectController::class, 'store'])->name('Added Project');

    // Edit Project
    Route::get('/project/{id}/edit', [ProjectController::class, 'index_update'])->name('Edit Project');
    Route::patch('/project/{id}/edit', [ProjectController::class, 'update'])->name('Edited Project');

    // Delete Project
    Route::delete('/project/{id}/delete', [ProjectController::class, 'destroy'])->name('Delete Project');

    // Sub activity
    Route::get('/subactivity', [SubActivityController::class, 'index'])->name('List Subactivity');
    // Add Sub activity by Project Manager
    Route::get('/subactivity/add', [SubActivityController::class, 'index_add'])->name('Add Subactivity');
    Route::post('/subactivity/add', [SubActivityController::class, 'store'])->name('Added Subactivity');
    // Edit Sub activity by Project Manager
    Route::get('/subactivity/{id}/edit', [SubActivityController::class, 'index_update'])->name('Edit Subactivity');
    Route::patch('/subactivity/{id}/edit', [SubActivityController::class, 'update'])->name('Edited Subactivity');

    // Report List
    Route::get('/report', [PerformanceController::class, 'index'])->name('List Report');
    // Add Report by HR
    Route::get('/report/add', [PerformanceController::class, 'index_add'])->name('Add Report');
    Route::post('/report/add', [PerformanceController::class, 'store'])->name('Added Report');
    // Edit Report by HR
    Route::get('/report/{id}/edit', [PerformanceController::class, 'index_update'])->name('Edit Report');
    Route::patch('/report/{id}/edit', [PerformanceController::class, 'update'])->name('Edited Report');
    // Delete Report by HR where status Cancelled
    Route::delete('/report/{id}/delete', [PerformanceController::class, 'destroy'])->name('Delete Report');
    // Download report
    Route::get('/report/{id}/download', [PerformanceController::class, 'downloadPdf'])->name('Download Report');

    // Activity Data
    Route::get('/group-activity', [ActivityController::class, 'index_group'])->name('Group Activity');
    Route::get('/group-activity/{id}/detail', [ActivityController::class, 'index_activity_group'])->name('Group Activities');
    Route::get('/your-activity', [ActivityController::class, 'index'])->name('Your activity');

    // Add Activity
    Route::get('/group-activity/{id}/add', [ActivityController::class, 'index_add_group'])->name('Add Activity Group');
    Route::post('/group-activity/{id}/add', [ActivityController::class, 'store_activity'])->name('Added Activity Group');

    // Delete Activity
    Route::delete('/group-activity/{groupId}/{activityId}/delete', [ActivityController::class, 'destroy'])->name('Delete Activity Group');

    // Edit Activity
    Route::get('/group-activity/{groupId}/{activityId}/edit', [ActivityController::class, 'index_edit_group'])->name('Edit Activity Group');
    Route::patch('/group-activity/{groupId}/{activityId}/edit', [ActivityController::class, 'update_activity'])->name('Edited Activity Group');
    Route::get('/your-activity/{id}/edit', [ActivityController::class, 'index_edit'])->name('Edit Your Activity');
    Route::patch('/your-activity/{id}/edit', [ActivityController::class, 'update'])->name('Edited Your Activity');

    // Comment
    Route::get('/activity/{id}/comments', [CommentController::class, 'index'])->name('Comments');
    Route::post('/activity/{id}/comments', [CommentController::class, 'store'])->name('Add Comments');
    Route::delete('/comments/{id}/delete', [CommentController::class, 'destroy'])->name('Delete Comments');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('Edit Comments');

    // Download
    Route::get('/download', [EmployeeController::class, 'download'])->name('Download');
});
