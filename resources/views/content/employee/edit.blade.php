@extends('layout.app')

@section('title', 'Edit Employee')

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Edit Employee</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Edited Employee', ['id' => $data->employeeId]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employeeName" class="form-control" id="exampleInputName1"
                                        value="{{ $data->employeeName }}" placeholder="Employee Name" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputEmail1" class="col-form-label col-sm-2">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="employeeEmail" class="form-control" id="exampleInputEmail1"
                                        value="{{ $data->employeeEmail }}" placeholder="Employee Email" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputPhone1" class="col-form-label col-sm-2">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" name="noTelp" class="form-control" id="exampleInputPhone1"
                                        value="{{ $data->noTelp }}" placeholder="Phone Number" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputDOB1" class="col-form-label col-sm-2">DOB</label>
                                <div class="col-sm-10">
                                    <input type="date" name="DOB" class="form-control" id="exampleInputDOB1"
                                        value="{{ $data->DOB }}" placeholder="DOB" required>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-sm-2 me-3"></div>
                                <div class="form-check col-sm-2 form-check-inline align-items-center">
                                    <input class="form-check-input" type="radio" name="gender" id="M"
                                        value="M" {{ $data->gender == 'M' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="M">Male</label>
                                </div>
                                <div class="form-check form-check-inline col-sm-2 align-items-center">
                                    <input class="form-check-input" type="radio" name="gender" id="F"
                                        value="F" {{ $data->gender == 'F' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="F">Female</label>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputPosition1" class="col-form-label col-sm-2">Position</label>
                                <div class="col-sm-10">
                                    <select name="positionId" class="form-control" id="exampleInputPositon1" required>
                                        <option value="">Select Your Position</option>
                                        @foreach ($positions as $option)
                                            <option value="{{ $option->positionId }}"
                                                {{ $option->positionId == $data->positionId ? 'selected' : '' }}>
                                                {{ $option->positionName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputAddress1" class="col-form-label col-sm-2">Address</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="employeeAddress" class="form-control" id="exampleInputAddress1" required>{{ $data->employeeAddress }}</textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span>Default Password : <span class="text-info">password</span></span>
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
                                            href={{ route('List Employee') }}>Back</a></button>
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
