@extends('layout.app')

@section('title', 'Group')

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        @php
            $foundGroup = false;
        @endphp
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Group</h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="@if (Session::get('employee')->positionId === 2) me-3 @endif">
                            @include('component.search.search', ['action' => route('Group List')])
                        </div>
                        @if (Session::get('employee')->positionId === 2)
                            <button type="button" class="btn btn-info">
                                <a class="text-decoration-none text-white fw-bold" href={{ route('Add Group') }}>New</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($groups->isNotEmpty())
                @foreach ($groups as $data)
                    <div class="stretch-card @if ($groups->isNotEmpty()) gap-5 @endif" style="width: 18rem;">
                        @php
                            $leader = $data->employees->firstWhere('pivot.isLeader', true);
                            $isMember = $data->employees->contains('employeeId', Session::get('employee')->employeeId);
                        @endphp
                        @if ($isMember)
                            @php
                                $foundGroup = true;
                            @endphp
                            <div class="card mb-3" style="width: 18rem; cursor: pointer;"
                                onclick="window.location.href='{{ route('Group Detail', ['id' => $data->groupId]) }}';">
                                <div class="card-body">
                                    <h5 class="card-title fs-5 mb-auto">{{ $data->groupName }}</h5>
                                    <hr class="m-0">
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        {{ $isMember }}
                                        Leader: {{ $leader ? $leader->employeeName : '-' }}
                                    </h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Project :
                                        {{ optional($data->projects)->projectName ?: '-' }} </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="card-link fs-6">{{ $data->employees->count() }}
                                            Member</span>
                                        @if (Session::get('employee')->positionId === 2 && $data->projects && $data->projects->status === 'Canceled')
                                            <a href="{{ route('Delete Group', ['id' => $data->groupId]) }}"
                                                class="text-decoration-none text-danger fw-bold delete-btn"
                                                data-group-id="{{ $data->groupId }}">
                                                <i class="fa-solid fa-trash icon"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        @if (!$foundGroup)
            <div class="row">
                <div class="py-5">
                    <h1 class="font-weight-bold mb-0 text-center py-5">No Data Available</h1>
                </div>
            </div>
        @endif
        @if ($groups->hasPages())
            <div class="card-footer">
                {{ $groups->links() }}
            </div>
        @endif
    @else
        @include('error.page404')
    @endif
@endsection
