@extends('layout.app')

@section('title', 'Member List')

@php
    $leader = $groups->employees->firstWhere('pivot.isLeader', true);
    $i = 1;
@endphp

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div class="row mb-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-3">
                        <h1 class="fw-bold me-3">{{ $groups->groupName }}</h1>
                        @if (Session::get('employee')->positionId === 2)
                            <a class="text-decoraration-none" href={{ route('Edit Group', ['id' => $groups->groupId]) }}><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        @endif
                    </div>
                    <h6 class="fw-normal">Leader: {{ $leader->employeeName }} </h6>
                    <h6 class="fw-normal">Project: {{ optional($groups->projects)->projectName ?: '-' }}</h6>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="d-flex align-self-center">
                <h4 class="fw-bold">Member List</h4>
            </div>
            <div>
                @if ($groups->employees->count() <= 5 && Session::get('employee')->positionId === 2)
                    <button type="button" class="btn btn-info">
                        <a class="text-decoration-none text-white fw-bold"
                            href={{ route('Add Member', ['id' => $groups->groupId]) }}>New</a>
                    </button>
                @endif
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
                                    @foreach ($details as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $data->employeeName }}</td>
                                            <td>{{ $data->employeeEmail }}</td>
                                            <td>{{ $data->positions->positionName }}</td>
                                            <td class="d-flex justify-content-center">
                                                @if (!$data->pivot->isLeader && Session::get('employee')->positionId === 2)
                                                    <a href="{{ route('Delete Member', ['groupId' => $data->pivot->groupId, 'employeeId' => $data->employeeId]) }}"
                                                        class="text-decoration-none text-danger fw-bold"
                                                        data-confirm-delete="true">Delete</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- @if ($details->hasPages())
                        <div class="card-footer">
                            {{ $details->links() }}
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
