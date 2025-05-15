@extends('layouts.index')
@section('title', 'Update User Details')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update User Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update User Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update User Details</h3>
                            </div>
                            <form method="POST" action="{{ route('admin.user_update', $user->id) }}">
                                @csrf
                                @method('POST')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Update User Name</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="name"
                                            placeholder="Update User Name" value="{{ old('name', $user->name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Update User Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                                            placeholder="Update User Email" value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputMobile1">Update User Mobile Number</label>
                                        <input type="tel" class="form-control" id="exampleInputMobile1" name="mobile"
                                            placeholder="Update User Mobile Number"
                                            value="{{ old('mobile', $user->mobile) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Update User Role</label>
                                        <select class="form-control select2" style="width: 100%;" name="role">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ $role == $user->role ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Update User Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            name="password" placeholder="Update User Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Update User Confirm Password</label>
                                        <input type="password" class="form-control" id="exampleInputConfirmPassword1"
                                            name="password_confirmation" placeholder="Update User Confirm Password">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
