@extends('layout.app')

@section('title', 'Report List')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">
                        @if (Session::get('employee')->positionId === 1)
                            Report List
                        @else
                            My Report
                        @endif
                    </h4>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    @if (Session::get('employee')->positionId === 1)
                        <div class="me-3">
                            @include('component.search.search', ['action' => route('List Report')])
                        </div>
                    @endif
                    <form action="" method="GET" class="m-0 @if (Session::get('employee')->positionId === 1) me-3 @endif">
                        <div class="input-group rounded">
                            <input type="month" name="date" class="form-control rounded" id="reportDate"
                                value="{{ request('date') }}" onchange="this.form.submit()">
                        </div>
                    </form>
                    @if (Session::get('employee')->positionId === 1)
                        <button type="button" class="btn btn-info">
                            <a class="text-decoration-none text-white fw-bold" href={{ route('Added Report') }}>New</a>
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
                                @php
                                    $i = $performances->firstitem();
                                @endphp
                                @if ($performances->isNotEmpty())
                                    @foreach ($performances as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if (Session::get('employee')->positionId === 1)
                                                <td>{{ $data->employees->employeeName }}</td>
                                            @endif
                                            <td>{{ $data->evaluationDate }}</td>
                                            <td>{{ $data->description }}</td>
                                            @if (Session::get('employee')->positionId === 1)
                                                <td>{{ $data->status }}</td>
                                            @endif
                                            <td>{{ $data->notes }}</td>
                                            <td class="text-center">
                                                @if (Session::get('employee')->positionId === 1)
                                                    @if ($data->status == 'Pending')
                                                        <a href={{ route('Edit Report', ['id' => $data->performanceId]) }}
                                                            class="text-decoration-none text-warning fw-bold pe-3">Update
                                                            Report
                                                            <i class="fas fa-sync-alt"></i>
                                                        </a>
                                                    @elseif ($data->status == 'Completed')
                                                        <a href={{ route('Download Report', ['id' => $data->performanceId]) }}
                                                            class="text-decoration-none text-primary fw-bold pe-3"
                                                            target="_blank">Download Pdf
                                                            <i class="bi bi-cloud-arrow-down-fill"></i>
                                                        </a>
                                                    @elseif ($data->status == 'Cancelled')
                                                        <a href={{ route('Delete Report', ['id' => $data->performanceId]) }}
                                                            class="text-decoration-none text-danger fw-bold pe-3"
                                                            data-confirm-delete="true">Delete
                                                            <i class="bi bi-file-earmark-x-fill"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    @if ($data->status == 'Completed')
                                                        <a href={{ route('Download Report', ['id' => $data->performanceId]) }}
                                                            class="text-decoration-none text-primary fw-bold pe-3"
                                                            target="_blank">Download Pdf
                                                            <i class="bi bi-cloud-arrow-down-fill"></i>
                                                        </a>
                                                    @endif
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
                {{-- Pagination --}}
                @if ($performances->hasPages())
                    <div class="card-footer">
                        {{ $performances->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
