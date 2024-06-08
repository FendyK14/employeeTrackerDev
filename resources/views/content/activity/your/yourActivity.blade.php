@extends('layout.app');

@section('title', 'Your Activity List');

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Activity List</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div class="">
                            @include('component.search.search', [
                                'action' => route('Your activity'),
                            ])
                        </div>
                        {{-- <a class="text-decoration-none text-white fw-bold btn btn-info" role="button"
                            href={{ route('Add Position') }}>New</a> --}}
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
                                        <th class="@if ($head === 'Action') text-center @endif">
                                            {{ $head }}
                                        </th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    <?php
                                    $i = $activity->firstItem();
                                    ?>
                                    @if ($activity->isNotEmpty())
                                        @foreach ($activity as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
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
                                                <td class="text-center">
                                                    <a href={{ route('Comments', ['id' => $data->activityId]) }}
                                                        class="text-decoration-none text-secondary fw-bold pe-3"><i
                                                            class="fa-solid fa-comments menu-icon"></i></a>
                                                    <a href={{ route('Edit Your Activity', ['id' => $data->activityId]) }}
                                                        class="text-decoration-none text-warning fw-bold">Edit</a>
                                                    {{-- 
                                                <a href="" class="text-decoration-none text-danger fw-bold"
                                                    data-confirm-delete="true">Delete</a> --}}

                                                </td>
                                            </tr>
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
                    @if ($activity->hasPages())
                        <div class="card-footer">
                            {{ $activity->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
