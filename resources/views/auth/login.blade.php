@extends('layout.app')

@section('title', 'Login')

@section('content')
    <div class="page-body-login full-page-login">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-6 mx-auto">
                    <div class="auth-form-light text-left py-3 px-4 px-sm-5">
                        <form class="pt-3" method="POST">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-danger text-center error-message">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label fs-6">Email</label>
                                <input type="email" name="employeeEmail" class="form-control" id="exampleInputEmail1"
                                    placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="form-label fs-6">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password" required>
                            </div>
                            <div class="text-center font-weight-light d-flex pt-2">
                                Don't have an account? <a href="{{ route('AuthenticateCompany') }}" class="text-primary"> Click here to
                                    register</a>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-block btn-primary fw-bold auth-form-btn"
                                    href={{ route('Dashboard') }}>Login</button>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="auth-form-bottom  text-left py-3 px-4 px-sm-5">
                        <span class="d-flex justify-content-center align-items-center">
                            <a href="#" class="text-decoration-none auth-text">Forgot Password</a>
                        </span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
