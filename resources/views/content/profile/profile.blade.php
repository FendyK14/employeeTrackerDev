@extends('layout.app')

@section('title', 'User Profile')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">User Profile</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="stretch-card">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? '' : 'active' }}"
                                aria-current="page" data-bs-toggle="tab" href="#myprofile">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#changepassword">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Profile Update Form -->
                        <div id="myprofile"
                            class="container tab-pane {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? '' : 'active' }}">
                            <form class="pt-3" method="POST" enctype="multipart/form-data"
                                action="{{ route('Edit User Profile', ['id' => $data->employeeId]) }}">
                                @csrf
                                @method('PATCH')
                                <div class="row my-3 align-items-center">
                                    <label for="exampleInputName1" class="col-form-label col-sm-2">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="employeeName" class="form-control"
                                            value="{{ $data->employeeName }}" id="exampleInputName1" readonly required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="exampleInputEmail1" class="col-form-label col-sm-2">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="employeeEmail" class="form-control"
                                            value="{{ $data->employeeEmail }}" id="exampleInputEmail1" required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="exampleInputDate1" class="col-form-label col-sm-2">DOB</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="DOB" class="form-control"
                                            value="{{ $data->DOB }}" id="exampleInputDate1" required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="exampleInputPhone1" class="col-form-label col-sm-2">Phone Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="noTelp" class="form-control"
                                            value="{{ $data->noTelp }}" id="exampleInputPhone1" required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="exampleInputPosition1" class="col-form-label col-sm-2">Position</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="positionName" class="form-control"
                                            value="{{ $data->positions->positionName }}" readonly id="exampleInputPosition1"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="exampleInputAddress1" class="col-form-label col-sm-2">Address</label>
                                    <div class="col-sm-10">
                                        <textarea name="employeeAddress" class="form-control" id="exampleInputAddress1" required>{{ $data->employeeAddress }}</textarea>
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
                        <!-- Password Change Form -->
                        <div id="changepassword"
                            class="container tab-pane {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? 'active' : 'fade' }}">
                            <form class="pt-3" method="POST" enctype="multipart/form-data"
                                action="{{ route('Edit User Password', ['id' => $data->employeeId]) }}">
                                @csrf
                                @method('PATCH')
                                <div class="row my-3 align-items-center">
                                    <label for="currentpassword1" class="col-form-label col-sm-2">Current Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="current_password" class="form-control"
                                            id="currentpassword1" placeholder="Current Password" required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="newpassword1" class="col-form-label col-sm-2">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="new_password" class="form-control"
                                            id="newpassword1" placeholder="New Password" required>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <label for="renewpassword" class="col-form-label col-sm-2">Re-Enter New
                                        Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                            id="renewpassword" placeholder="Re-Enter New Password" required>
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
        </div>
    </div>
@endsection
