@extends('layout.app')

@section('title', 'Add Member')

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Add Member</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputEmployeeName1" class="col-form-label col-sm-2">Employee Name</label>
                                <div class="col-sm-10">
                                    <select name="employeeId" class="form-control" id="exampleInputEmployeeName1" required>
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->employeeId }}">{{ $employee->employeeName }} -
                                                {{ $employee->positions->positionName }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                            href={{ route('Group Detail', ['id' => $groups->groupId]) }}>Back</a></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
