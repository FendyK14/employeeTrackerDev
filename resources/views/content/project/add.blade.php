@extends('layout.app')

@section('title', 'Add Project')

@section('content')
    @if (Session::get('employee')->positionId === 2)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Add Project</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data" action={{ route('Added Project') }}>
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Project Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="projectName" class="form-control" id="exampleInputName1"
                                        placeholder="Project Name" required>
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
                                        placeholder="Start Date" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputGroupName1" class="col-form-label col-sm-2">Group Name</label>
                                <div class="col-sm-10">
                                    <select name="groupId" class="form-control" id="exampleInputGroupName1" required>
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $data)
                                            <option value="{{ $data->groupId }}">{{ $data->groupName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStatus1" class="col-form-label col-sm-2">Status</label>
                                <div class="col-sm-10">
                                    <input type="text" name="status" value="Pending" class="form-control" id="exampleInputStatus1"
                                        placeholder="Pending" readonly required>
                                </div>
                                {{-- <div class="col-sm-10">
                                    <select name="status" class="form-control" id="exampleInputStatus1" required>
                                        <option value="Incomplete">Incomplete</option>
                                        <option value="Canceled">Canceled</option>
                                        <option value="Active">Active</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                </div> --}}
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center me-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary fw-bold auth-form-btn">Save</button>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-block btn-outline-secondary fw-bold auth-form-btn"> <a
                                            class="text-decoration-none" href={{ route('List Project') }}>Back</a></button>
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
