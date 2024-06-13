@extends('layout.app')

@section('title', 'Register Company')

@section('content')
    <div class="page-body-login full-page-login">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-6 mx-auto">
                    <div class="auth-form-light text-left py-3 px-4 px-sm-5">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('AuthenticateCompany') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1" class="form-label fs-6">Company Name</label>
                                <input type="text" name="companyName" class="form-control " id="exampleInputName1"
                                    placeholder="Your Company Name" required>
                                @error('companyName')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label fs-6">Company Email</label>
                                <input type="email" name="companyEmail" class="form-control" id="exampleInputEmail1"
                                    placeholder="Your Company Email" required>
                                @error('companyEmail')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone1" class="form-label fs-6">Company Phone Number</label>
                                <input type="text" name="companyPhone" class="form-control" id="exampleInputPhone1"
                                    placeholder="Your Company Phone" required>
                                @error('companyPhone')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputAddress1" class="form-label fs-6">Company Address</label>
                                <input type="text" name="companyAddress" class="form-control" id="exampleInputAddress1"
                                    placeholder="Your Company Address" required>
                                @error('companyAddress')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-center font-weight-light d-flex pt-2">
                                    Already have a company? <a href={{ route('RegisterUser') }} class="text-primary">
                                        Click here</a>
                                </div>
                                <div class="text-center font-weight-light d-flex pt-2">
                                    Already have an account? <a href={{ route('Authenticate') }} class="text-primary">
                                        Login here</a>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-block btn-primary fw-bold auth-form-btn">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
