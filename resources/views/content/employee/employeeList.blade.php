@extends('layout.app');

@section('title', 'Employee List');

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Employee List</h4>
                    </div>
                    <div class="d-flex justity-content-between align-items-center">
                        <div class="me-3">
                            @include('component.search.search', ['action' => route('List Employee')])
                        </div>
                        <button type="button" class="btn btn-info me-3">
                            <a class="text-decoration-none text-white fw-bold" href={{ route('Add Employee') }}>New</a>
                        </button>
                        <button type="button" data-toggle="modal" data-target="#importExcel"
                            class="file-upload-browse btn btn btn-primary btn-icon-text btn-rounded">
                            <i class="fa-solid fa-circle-plus"></i> Import
                        </button>
                        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
                                <form method="POST" action={{ route('Import') }} enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                                        </div>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="file"
                                                    id="inputGroupFile02">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                            </div>
                                            <span>Template import data </span><a href={{ asset('template/template-import.xlsx') }}>Download</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit"
                                                class="file-upload-browse btn btn btn-primary btn-icon-text">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                    $i = $employees->firstItem();
                                    ?>
                                    @foreach ($employees as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $data->employeeName }}</td>
                                            <td> {{ $data->DOB }}</td>
                                            <td> {{ $data->gender === 'M' ? 'Male' : 'Female' }}</td>
                                            <td>{{ $data->employeeEmail }}</td>
                                            <td>{{ $data->noTelp }}</td>
                                            <td>{{ $data->employeeAddress }}</td>
                                            <td>{{ $data->positions->positionName }}</td>
                                            <td class="text-center">
                                                <a href={{ route('Edit Employee', ['id' => $data->employeeId]) }}
                                                    class="text-decoration-none text-warning fw-bold pe-3">Edit</a>
                                                <a href="{{ route('Delete Employee', ['id' => $data->employeeId]) }}"
                                                    class="text-decoration-none text-danger fw-bold"
                                                    data-confirm-delete="true">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($employees->hasPages())
                        <div class="card-footer">
                            {{ $employees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
