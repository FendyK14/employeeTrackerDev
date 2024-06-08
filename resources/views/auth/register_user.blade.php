@extends('layout.app')

@section('title', 'Register User')

@section('content')
    <div class="page-body-login full-page-login">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-6 mx-auto py-5">
                    <div class="auth-form-light text-left py-3 px-4 px-sm-5">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('AuthenticateUser') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1" class="form-label fs-6">Name</label>
                                <input type="text" name="employeeName" class="form-control" id="exampleInputName1"
                                    placeholder="Your Name" required>
                                @error('employeeName')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label fs-6">Email</label>
                                <input type="email" name="employeeEmail" class="form-control" id="exampleInputEmail1"
                                    placeholder="Your Email" required>
                                @error('employeeEmail')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDOB1" class="form-label fs-6">DOB</label>
                                <input type="date" name="DOB" class="form-control" id="exampleInputDOB1"
                                    placeholder="Your DOB" required>
                                @error('DOB')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone1" class="form-label fs-6">Phone Number</label>
                                <input type="text" name="noTelp" class="form-control" id="exampleInputPhone1"
                                    placeholder="Your Phone Number" required>
                                @error('noTelp')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline align-items-center">
                                <input class="form-check-input" type="radio" name="gender" id="M" value="M"
                                    required>
                                <label class="form-check-label fs-6" for="M">Male</label>
                            </div>
                            <div class="form-check form-check-inline align-items-center pb-3">
                                <input class="form-check-input" type="radio" name="gender" id="F" value="F"
                                    required>
                                <label class="form-check-label fs-6" for="F">Female</label>
                            </div>
                            @error('gender')
                                <div class="alert alert-danger error-message">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-group">
                                <label for="exampleInputAddress1" class="form-label fs-6">Address</label>
                                <input type="text" name="employeeAddress" class="form-control" id="exampleInputAddress1"
                                    placeholder="Your Address" required>
                                @error('employeeAddress')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="form-label fs-6">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password" required>
                                @error('password')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1" class="form-label fs-6">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="exampleInputConfirmPassword1" placeholder="Confirm Password" required>
                                @error('password_confirmation')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCompany1" class="form-label fs-6">Company</label>
                                <select name="companyId" class="form-control" id="exampleInputCompany1" required>
                                    <option value="">Select Your Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->companyId }}">{{ $company->companyName }}</option>
                                    @endforeach
                                </select>
                                @error('companyId')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPosition1" class="form-label fs-6">Position</label>
                                <select name="positionId" class="form-control" id="exampleInputPosition1" required>
                                    <option value="">Select Position</option>
                                    <option value="1">HR</option>
                                    <option value="2">Project Manager</option>
                                </select>
                                @error('positionId')
                                    <div class="alert alert-danger error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="text-center font-weight-light d-flex pt-2">
                                Already have an account? <a href={{ route('Authenticate') }} class="text-primary">
                                    Login here</a>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-block btn-primary fw-bold auth-form-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
