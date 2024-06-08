@extends('layout.app')

@section('title', 'Edit Employee')

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Edit Attendance</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Edited Attendance', $data->attendanceId) }}">
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Employee Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employeeName" value="{{ $data->employees->employeeName }}"
                                        class="form-control" id="exampleInputName1" placeholder="Employee Name" readonly>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputClockIn1" class="col-form-label col-sm-2">Clock In</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="clockIn" class="form-control"
                                        id="exampleInputClockIn1"
                                        value="{{ date('Y-m-d\TH:i', strtotime($data->clockIn)) }}" placeholder="Clock In"
                                        required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputClockOut1" class="col-form-label col-sm-2">Clock Out</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" name="clockOut" class="form-control"
                                        id="exampleInputClockOut1" value="{{ $data->clockOut }}" placeholder="Clock Out">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputWorkType1" class="col-form-label col-sm-2">Work Type</label>
                                <div class="col-sm-10">
                                    <select name="workType" class="form-control" id="workTypeSelect" required>
                                        <option value="">Select Work Type</option>
                                        <option value="WFH" {{ $data->workType == 'WFH' ? 'selected' : '' }}>WFH</option>
                                        <option value="WFO" {{ $data->workType == 'WFO' ? 'selected' : '' }}>WFO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center" id="imageUploadSection" style="display: none;">
                                <label for="exampleInputImage1" class="col-form-label col-sm-2">Image
                                    <span style="color: grey;">(only for WFH)</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control" id="exampleInputImage1">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStatus1" class="col-form-label col-sm-2">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control" id="exampleInputStatus1"
                                        {{ $data->status ? 'selected' : '' }} required>
                                        <option value="">Select Status</option>
                                        @foreach (['Present', 'Absent', 'Completed'] as $option)
                                            <option value="{{ $option }}"
                                                {{ $option == $data->status ? 'selected' : '' }}>{{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3 align-items-center" id="currentImageSection" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <label class="col-form-label col-sm-2">Current Image</label>
                                    <div class="col-sm-10">
                                        <img src="{{ asset('storage/' . $data->image) }}" alt="Current Image"
                                            class="mb-2 ms-1" style="max-width: 100px;">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center me-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary fw-bold auth-form-btn">Save</button>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-block btn-outline-secondary fw-bold auth-form-btn">
                                        <a class="text-decoration-none" href="{{ route('Attendance') }}">Back</a>
                                    </button>
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
