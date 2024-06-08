@extends('layout.app');

@section('title', 'Attendance');

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div>
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0">Attendance</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- column 1: User Info -->
                                <div class="col-md-4 d-flex align-item-center">
                                    <i class="bi bi-person-circle profile-pic me-2" style="font-size: 2rem;"></i>
                                    <div>
                                        <h5>{{ Session::get('employee')->employeeName }}</h5>
                                    </div>
                                </div>

                                <!-- column 2: Work Type and Choose Image -->
                                <div class="col-md-4">
                                    <form id="attendanceForm" method="POST" action="{{ route('Attendance CheckIn') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputWorkType1" class="form-label fs-6">Select Work
                                                Type</label>
                                            <select name="workType" class="form-select" id="exampleInputWorkType1" required>
                                                <option value="">Select Work Type</option>
                                                <option value="WFH">WFH</option>
                                                <option value="WFO">WFO</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="imageUpload" style="display: none;">
                                            <label class="form-label fs-6">Choose Image
                                                <span style="color: grey;">(only for WFH)</span>
                                            </label>
                                            <input type="file" class="form-control" name="file" id="inputGroupFile05">
                                        </div>
                                    </form>
                                </div>

                                <!-- column 3: Check In and Check Out -->
                                <div class="col-md-4">
                                    <div class="form-group" style="margin-top: 30px">
                                        <button class="btn btn-success w-100" id="checkInButton">
                                            <i class="fas fa-sign-in-alt"></i> Check In
                                        </button>
                                    </div>
                                    <div class="form-group" style="margin-top: 55px">
                                        <form id="checkOutForm" method="POST" action="{{ route('Attendance CheckOut') }}">
                                            @csrf
                                            <button type="button" class="btn btn-danger w-100" id="checkOutButton">
                                                <i class="fas fa-sign-out-alt"></i> Check Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">
                            @if (Session::get('employee')->positionId === 1)
                                Attendance List
                            @else
                                History
                            @endif
                        </h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        @if (session('employee')->positionId == 1)
                            <div class="me-3">
                                @include('component.search.search', ['action' => route('Attendance')])
                            </div>
                        @endif
                        <form action="{{ route('Attendance') }}" method="GET"
                            class="m-0 @if (Session::get('employee')->positionId === 1) me-3 @endif">
                            <div class="input-group rounded">
                                <input type="date" name="date" class="form-control rounded" id="attendanceDate"
                                    value="{{ request('date') }}" onchange="this.form.submit()">
                            </div>
                        </form>
                        @if (session('employee')->positionId == 1)
                            <button type="button" class="btn btn-info">
                                <a class="text-decoration-none text-white fw-bold"
                                    href={{ route('Add Attendance') }}>New</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    @foreach ($header as $head)
                                        <th class=" @if ($head === 'Action') text-center @endif">
                                            {{ $head }}
                                        </th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $attendances->firstItem();
                                    ?>
                                    @if ($attendances->isNotEmpty())
                                        @foreach ($attendances as $data)
                                            @if (Auth::guard('employee')->user()->position == 1 || $data->employees->id == Auth::guard('employee')->user()->id)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    @if (session('employee')->positionId == 1)
                                                        <td>{{ $data->employees->employeeName }}</td>
                                                    @endif
                                                    <td>{{ $data->clockIn }}</td>
                                                    <td>{{ $data->clockOut }}</td>
                                                    <td>{{ $data->workType }}</td>
                                                    <td>{{ $data->status }}</td>
                                                    <td>
                                                        @if ($data->image != '-')
                                                            <img src="{{ asset('storage/' . $data->image) }}"
                                                                alt="Attendance Image" style="max-width: 100px;">
                                                        @else
                                                            {{ $data->image }}
                                                        @endif
                                                    </td>
                                                    @if (session('employee')->positionId == 1 && $data->status !== 'Completed')
                                                        <td class="text-center">
                                                            <a href={{ route('Edit Attendance', ['id' => $data->attendanceId]) }}
                                                                class="text-decoration-none text-warning fw-bold">Edit</a>
                                                        </td>
                                                    @else
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="{{ count($header) }}" class="text-center align-middle">
                                                No Data
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($attendances->hasPages())
                        <div class="card-footer">
                            {{ $attendances->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @push('scripts')
    <script>
        document.getElementById('checkInButton').addEventListener('click', function() {
            document.getElementById('attendanceForm').submit();
        });

        document.getElementById('checkOutButton').addEventListener('click', function() {
            document.getElementById('checkOutForm').submit();
        });
    </script>
@endpush --}}
