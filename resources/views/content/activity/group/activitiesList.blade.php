@extends('layout.app')

@section('title', 'Group activity List')

@section('content')
    @if (Session::get('employee')->positionId !== 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">{{ optional($project->projects)->projectName ?: '' }} Activity List
                        </h4>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="@if (Session::get('employee')->positionId === 2 && $project->projects) me-3 @endif">
                            @include('component.search.search', ['action' => route('Group List')])
                        </div>
                        @if (Session::get('employee')->positionId === 2 && $project->projects)
                            <button type="button" class="btn btn-info">
                                <a class="text-decoration-none text-white fw-bold"
                                    href={{ route('Add Activity Group', ['id' => $project->groupId]) }}>New</a>
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
                                    $i = $activity->firstItem();
                                    ?>
                                    @if ($activity->isNotEmpty())
                                        @foreach ($activity as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->employees->employeeName }}</td>
                                                <td>{{ $data->activityName }}</td>
                                                <td>{{ $data->sub_activities->subActivityName }}</td>
                                                <td>{{ $data->startDate }}</td>
                                                <td>{{ $data->endDate ?: '-' }}</td>
                                                <td style="white-space: normal !important">{{ $data->description ?: '-' }}
                                                </td>
                                                <td>{{ ['High', 'Medium', 'Low'][$data->priority - 1] }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td class="text-center">
                                                    {{-- <a role="button" data-toggle="modal"
                                                        data-target="#comments-{{ $data->activityId }}"
                                                        class="text-secondary me-3">
                                                        <i class="fa-solid fa-comments menu-icon"></i>
                                                    </a>
                                                    <div class="modal fade" id="comments-{{ $data->activityId }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable"
                                                            role="document">
                                                            <form method="POST" enctype="multipart/form-data"
                                                                action="{{ route('Add Comments', ['id' => $data->activityId]) }}">
                                                                @csrf
                                                                <div class="modal-content" style="width:500px !important">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="commentModalLabel">
                                                                            Comments</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <ul class="list-group">
                                                                            @if ($data->comments->isNotEmpty())
                                                                                @foreach ($activity->comments as $comment)
                                                                                    <li class="list-group-item">
                                                                                        {{ $comment->description }}</li>
                                                                                @endforeach
                                                                            @else
                                                                                <li class="list-group-item">No comments
                                                                                    available.</li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                    <div class="form-group mt-3">
                                                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div> --}}
                                                    <a href={{ route('Comments', ['id' => $data->activityId]) }}
                                                        class="text-decoration-none text-secondary fw-bold pe-3"><i
                                                            class="fa-solid fa-comments menu-icon"></i></a>
                                                    <a href={{ route('Edit Activity Group', ['groupId' => $project->groupId, 'activityId' => $data->activityId]) }}
                                                        class="text-decoration-none text-warning fw-bold @if (Session::get('employee')->positionId === 2) pe-3 @endif">Edit</a>
                                                    @if (Session::get('employee')->positionId === 2)
                                                        <a href="{{ route('Delete Activity Group', ['groupId' => $project->groupId, 'activityId' => $data->activityId]) }}"
                                                            class="text-decoration-none text-danger fw-bold"
                                                            data-confirm-delete="true">Delete</a>
                                                    @endif
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
