@extends('layout.app');

@section('title', 'Position List');

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Position List</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div class="me-3">
                            @include('component.search.search', [
                                'action' => route('List Position'),
                                'query' => $query,
                            ])
                        </div>
                        <a class="text-decoration-none text-white fw-bold btn btn-info" role="button"
                            href={{ route('Add Position') }}>New</a>
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
                                    $i = $positions->firstItem();
                                    ?>
                                    @foreach ($positions as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td style="width: 80%">{{ $data->positionName }}</td>
                                            <td style="width: 20%" class="text-center">
                                                @if (in_array($data->positionId, [1, 2]))
                                                    Default by System
                                                @else
                                                    <a href={{ route('Edit Position', ['id' => $data->positionId]) }}
                                                        class="text-decoration-none text-warning fw-bold pe-3">Edit</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($positions->hasPages())
                        <div class="card-footer">
                            {{ $positions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif

@endsection
