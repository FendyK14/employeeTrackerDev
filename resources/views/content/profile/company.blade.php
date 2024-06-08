@extends('layout.app')

@section('title', 'Company Profile')

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Company Profile</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Edit Company Profile', ['id' => $data->companyId]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Company Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="companyName"
                                        value="{{  $data->companyName }}" class="form-control"
                                        id="exampleInputName1" placeholder="Company Name" readonly>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Company Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="companyEmail"
                                        value="{{$data->companyEmail }}" class="form-control"
                                        id="exampleInputName1" placeholder="Company Email" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Company Phone
                                    Number</label>
                                <div class="col-sm-10">
                                    <input type="text" name="companyPhone"
                                        value="{{ $data->companyPhone }}" class="form-control"
                                        id="exampleInputName1" placeholder="Company Phone Number" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <label for="exampleFormControlTextarea1" class="col-form-label col-sm-2">Company
                                    Address</label>
                                <div class="col-sm-10">
                                    <textarea id="exampleFormControlTextarea1" rows="3" name="companyAddress"class="form-control"
                                        placeholder="Company Address" required>{{ $data->companyAddress }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="submit"
                                        class="btn btn-block btn-primary fw-bold auth-form-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
@endsection
