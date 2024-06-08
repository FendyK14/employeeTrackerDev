@extends('layout.app')

@section('title', 'Group Activity')
@php
    $foundGroup = false;
@endphp
@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Group Activity</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div>
                            @include('component.search.search', ['action' => route('Group Activity')])
                        </div>
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
                                onclick="window.location.href='{{ route('Group Activities', ['id' => $data->groupId]) }}';">
                                <div class="card-body">
                                    <h5 class="card-title fs-5 mb-auto">{{ $data->groupName }}</h5>
                                    <hr class="m-0">
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Leader: {{ $leader ? $leader->employeeName : '-' }}
                                    </h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Project :
                                        {{ optional($data->projects)->projectName ?: '-' }} </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span href="#" class="card-link fs-6">{{ $data->employees->count() }}
                                            Member</span>
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
