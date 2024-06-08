@extends('layout.app');

@section('title', 'Sub Activity List');

@section('content')
    @if (Session::get('employee')->positionId === 2)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Sub Activity List</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div class="me-3">
                            @include('component.search.search', ['action' => route('List Subactivity')])
                        </div>
                        <button type="button" class="btn btn-info">
                            <a class="text-decoration-none text-white fw-bold" href={{ route('Add Subactivity') }}>New</a>
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
                                    $i = $subActivity->firstItem();
                                    ?>
                                    @if ($subActivity->isNotEmpty())
                                        @foreach ($subActivity as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td style="width: 80%">{{ $data->subActivityName }}</td>
                                                <td class="text-center">
                                                    <a href={{ route('Edit Subactivity', ['id' => $data->subActivityId]) }}
                                                        class="text-decoration-none text-warning fw-bold">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan={{ count($header) }} class="text-center align-middle">
                                                No Data
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($subActivity->hasPages())
                        <div class="card-footer">
                            {{ $subActivity->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
