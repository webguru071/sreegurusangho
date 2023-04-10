@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Account profile') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item active" aria-current="page">Account profile</li>
        </ol>
    </nav>
@endsection

@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Index') }}</div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 25%;"><b>{{ __('Name') }}</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>

                        <tr>
                            <td><b>{{ __('Email') }}</b></td>
                            <td>:</td>
                            <td>{{  Auth::user()->email  }}</td>
                        </tr>

                        <tr>
                            <td><b>{{ __('Password') }}</b></td>
                            <td>:</td>
                            <td>************</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="App setting button">
                    <a href="{{ route("account.profile.edit") }}" type="button" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i> {{ __('Edit') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
