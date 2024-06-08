@extends('layout.app')

@section('title', 'Edit Sub Activity')

@section('content')
    @if (Session::get('employee')->positionId === 2)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Edit Sub Activity</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Edited Subactivity', ['id' => $subActivity->subActivityId]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Sub Activity Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="subActivityName" value="{{ $subActivity->subActivityName }}"
                                        class="form-control" id="exampleInputName1" placeholder="Sub Activity Name"
                                        required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center me-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary fw-bold auth-form-btn">Save</button>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-block btn-outline-secondary fw-bold auth-form-btn"> <a
                                            class="text-decoration-none"
                                            href={{ route('List Subactivity') }}>Back</a></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
