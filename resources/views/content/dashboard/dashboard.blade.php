@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
    {{-- dashboard - first table --}}
    <div class="row">
        <div class="stretch-card">
            <div class="card">
                <div class="card-body pb-0">
                    @if (Session::get('employee')->positionId === 1)
                        <p class="card-title">Attendance</p>
                    @else
                        <p class="card-title">Project</p>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                @foreach ($headerFirstTab as $head)
                                    <th>{{ $head }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                <?php
                                $i = $recordsFirstTab->firstItem();
                                ?>
                                @if ($recordsFirstTab->isNotEmpty())
                                    @foreach ($recordsFirstTab as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if (Session::get('employee')->positionId === 1)
                                                <td>{{ $data->employees->employeeName }}</td>
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
                                            @else
                                                <td>{{ $data->projectName }}</td>
                                                <td>{{ $data->startDate }}</td>
                                                <td>{{ $data->endDate }}</td>
                                                <td>{{ $data->status }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ count($headerFirstTab) }}" class="text-center align-middle">
                                            No Data
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($recordsFirstTab->hasPages())
                        <div class="card-footer">
                            {{ $recordsFirstTab->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        {{-- dashboard - second table --}}
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card border-bottom-0">
                <div class="card-body pb-0">
                    @if (Session::get('employee')->positionId === 1)
                        <p class="card-title">Employee Project</p>
                    @else
                        <p class="card-title">Activities</p>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                @foreach ($headerSecondTab as $head)
                                    <th>{{ $head }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                <?php
                                $i = $recordsSecondTab->firstItem();
                                ?>
                                @if ($recordsSecondTab->isNotEmpty())
                                    @foreach ($recordsSecondTab as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if (Session::get('employee')->positionId === 1)
                                                <td>{{ $data['employeeName']}}</td>
                                                <td>{{ $data['projectName'] }}</td>
                                                <td>{{ $data['startDate'] }}</td>
                                                <td>{{ $data['endDate'] }}</td>
                                                <td>{{ $data['status'] }}</td>
                                            @else
                                                <td>{{ $data->projects->groups->groupName }}</td>
                                                <td>{{ $data->activityName }}</td>
                                                <td>{{ $data->sub_activities->subActivityName }}</td>
                                                <td>{{ $data->startDate }}</td>
                                                <td>{{ $data->endDate ?: '-' }}</td>
                                                <td style="white-space: normal !important;">
                                                    {{ $data->description ?: '-' }}
                                                </td>
                                                <td>{{ ['High', 'Medium', 'Low'][$data->priority - 1] }}</td>
                                                <td>{{ $data->status }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ count($headerSecondTab) }}" class="text-center align-middle">
                                            No Data
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($recordsSecondTab->hasPages())
                        <div class="card-footer">
                            {{ $recordsSecondTab->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- dashboard - third table --}}
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card border-bottom-0">
                <div class="card-body pb-0">
                    @if (Session::get('employee')->positionId === 1)
                        <p class="card-title">Employee Activities</p>
                    @else
                        <p class="card-title">Group</p>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                @foreach ($headerThirdTab as $head)
                                    <th>{{ $head }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                <?php
                                $i = $recordsThirdTab->firstItem();
                                ?>
                                @if ($recordsThirdTab->isNotEmpty())
                                    @foreach ($recordsThirdTab as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if (Session::get('employee')->positionId === 1)
                                                <td>{{ $data->employees->employeeName }}</td>
                                                <td>{{ $data->activityName }}</td>
                                                <td>{{ $data->sub_activities->subActivityName }}</td>
                                                <td>{{ $data->startDate }}</td>
                                                <td>{{ $data->endDate ?: '-' }}</td>
                                                <td style="white-space: normal !important;">
                                                    {{ $data->description ?: '-' }}
                                                </td>
                                                <td>{{ ['High', 'Medium', 'Low'][$data->priority - 1] }}</td>
                                                <td>{{ $data->status }}</td>
                                            @else
                                                <td>{{ $data->groupName }}</td>
                                                <td>{{ $data->employees->first() ? $data->employees->first()->employeeName : '-' }}
                                                </td>
                                                <td>{{ $data->projects ? $data->projects->projectName : '-' }}</td>
                                                <td>{{ $data->projects ? $data->projects->status : '-' }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ count($headerThirdTab) }}" class="text-center align-middle">
                                            No Data
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($recordsThirdTab->hasPages())
                        <div class="card-footer">
                            {{ $recordsThirdTab->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
