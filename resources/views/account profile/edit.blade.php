@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Account profile') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("account.profile.index") }}">Account profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')

    <div class="card">
        <div class="card-header">{{ __('Account profile') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("account.profile.update") }}" method="POST" enctype="multipart/form-data" name="account_profile_update">
                @csrf
                @method("PATCH")

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="nameEnInput" class="col-md-4 col-form-label col-form-label-sm">Name</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control form-control-sm @error("name") is-invalid @enderror" id="nameInput" placeholder="Ex: Perfect HRM" value="{{ ( old("name") == null ) ? Auth::user()->name : old("name") }}" maxlength="200">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="emailEnInput" class="col-md-4 col-form-label col-form-label-sm">Email</label>
                            <div class="col-md-8">
                                <input type="email" name="email" class="form-control form-control-sm @error("email") is-invalid @enderror" id="emailInput" placeholder="Ex: Perfect HRM" value="{{ ( old("email") == null ) ? Auth::user()->email : old("email") }}" maxlength="200">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="passwordEnInput" class="col-md-4 col-form-label col-form-label-sm">Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control form-control-sm @error("password") is-invalid @enderror" id="passwordInput" placeholder="Ex: Perfect HRM" value="{{ old("password") }}" maxlength="200">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
