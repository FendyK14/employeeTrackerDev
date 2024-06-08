@extends('layout.app')

@section('title', 'Add Group Activity')
@php
    $priorityOptions = [
        1 => 'High',
        2 => 'Medium',
        3 => 'Low',
    ];
@endphp

@section('content')
    @if (Session::get('employee')->positionId === 2)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Add Activity</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action={{ route('Added Activity Group', ['id' => $group->groupId]) }}>
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Activity Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="activityName" class="form-control" id="exampleInputName1"
                                        placeholder="Activity Name" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputEmployee1" class="col-form-label col-sm-2">Employee Name</label>
                                <div class="col-sm-10">
                                    <select name="employeeId" class="form-control" id="exampleInputEmployee1" required>
                                        <option value="">Select Employee</option>
                                        @foreach ($group->employees as $option)
                                            <option value="{{ $option->employeeId }}">{{ $option->employeeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputSubActivity1" class="col-form-label col-sm-2">Sub Activity</label>
                                <div class="col-sm-10">
                                    <select name="subActivityId" class="form-control" id="exampleInputSubActivity1"
                                        required>
                                        <option value="">Select Sub Activity</option>
                                        @foreach ($subActivity as $option)
                                            <option value="{{ $option->subActivityId }}">{{ $option->subActivityName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStartDate1" class="col-form-label col-sm-2">Start Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="startDate" class="form-control" id="exampleInputStartDate1"
                                        placeholder="Start Date" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputEndDate1" class="col-form-label col-sm-2">End Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="endDate" class="form-control" id="exampleInputEndDate1"
                                        placeholder="End Date">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputPriority1" class="col-form-label col-sm-2">Priority</label>
                                <div class="col-sm-10">
                                    <select name="priority" class="form-control" id="exampleInputPriority1" required>
                                        <option value="">Select Priority</option>
                                        @foreach ($priorityOptions as $option => $label)
                                            <option value="{{ $option }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputDescription1" class="col-form-label col-sm-2">Description</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="description" class="form-control" id="exampleInputDescription1"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStatus1" class="col-form-label col-sm-2">Status</label>
                                <div class="col-sm-10">
                                    <input type="text" name="status" value="Pending" class="form-control"
                                        id="exampleInputStatus1" placeholder="Pending" readonly required>
                                    {{-- <select name="status" class="form-control" id="exampleInputStatus1" required>
                                        <option value="">Select Status</option>
                                        @foreach (['Pending', 'Canceled', 'Completed'] as $option)
                                            <option value="{{ $option }}">{{ $option }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center me-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary fw-bold auth-form-btn">Save</button>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-block btn-outline-secondary fw-bold auth-form-btn"> <a
                                            class="text-decoration-none"
                                            href={{ route('Group Activities', ['id' => $group->groupId]) }}>Back</a></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
