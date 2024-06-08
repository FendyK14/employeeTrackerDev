@extends('layout.app');

@section('title', 'Project List');

@section('content')
    @if (Session::get('employee')->positionId === 2)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Project List</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div class="@if (Session::get('employee')->positionId === 2) me-3 @endif">
                            @include('component.search.search', ['action' => route('List Project')])
                        </div>
                        <form action="{{ route('List Project') }}" method="GET" class="m-0 me-3">
                            <div class="input-group rounded">
                                <input type="month" name="date" class="form-control rounded" id="projectDate"
                                    value="{{ request('date') }}" onchange="this.form.submit()">
                            </div>
                        </form>
                        <button type="button" class="btn btn-info">
                            <a class="text-decoration-none text-white fw-bold" href={{ route('Added Project') }}>New</a>
                        </button>
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
                                    $i = $projects->firstItem();
                                    ?>
                                    @if ($projects->isNotEmpty())
                                        @foreach ($projects as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->projectName }}</td>
                                                <td> {{ $data->startDate }}</td>
                                                <td> {{ $data->endDate }}</td>
                                                <td>{{ $data->groups->groupName }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td class="text-center">
                                                    @if ($data->status === 'Completed')
                                                        -
                                                    @elseif ($data->status === 'Canceled')
                                                        <a href="{{ route('Delete Project', ['id' => $data->projectId]) }}"
                                                            class="text-decoration-none text-danger fw-bold"
                                                            data-confirm-delete="true">Delete</a>
                                                    @else
                                                        <a href={{ route('Edit Project', ['id' => $data->projectId]) }}
                                                            class="text-decoration-none text-warning fw-bold">Edit</a>
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
                    @if ($projects->hasPages())
                        <div class="card-footer">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
