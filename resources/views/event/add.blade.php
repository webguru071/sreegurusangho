@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Event') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("event.index") }}">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("event.save") }}" method="POST"  name="event_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" id="nameEnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_en") }}"  required>

                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameBnInput" class="col-md-4 col-form-label col-form-label-sm">Name (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" id="nameBnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_bn") }}"  required>

                                @error('name_bn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="dayEnInput" class="col-md-4 col-form-label col-form-label-sm">Day (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="day_en" class="form-control form-control-sm @error("day_en") is-invalid @enderror" id="dayEnInput" placeholder="Ex: Perfect HRM" value="{{ old("day_en") }}" maxlength="50" required>

                                @error('day_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="dayBnInput" class="col-md-4 col-form-label col-form-label-sm">Day (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="day_bn" class="form-control form-control-sm @error("day_bn") is-invalid @enderror" id="dayBnInput" placeholder="Ex: Perfect HRM" value="{{ old("day_bn") }}" maxlength="50" required>

                                @error('day_bn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="dateEnInput" class="col-md-4 col-form-label col-form-label-sm">Date (En)</label>
                            <div class="col-md-8">
                                <input type="date" name="date_en" class="form-control form-control-sm @error("date_en") is-invalid @enderror" id="dateEnInput" placeholder="Ex: Perfect HRM" value="{{ old("date_en") }}"  required>

                                @error('date_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="dateBnInput" class="col-md-4 col-form-label col-form-label-sm">Date (Bn)</label>
                            <div class="col-md-8">
                                <p id="dateBnInputText" class=" d-none"></p>
                                <input type="text" name="date_bn" class="form-control form-control-sm @error("date_bn") is-invalid @enderror" id="dateBnInput" placeholder="Ex: Perfect HRM" value="{{ old("date_bn") }}"  readonly required>

                                @error('date_bn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="detailsEnInput" class="col-md-4 col-form-label col-form-label-sm">Details (En)</label>
                            <div class="col-md-8">
                                <textarea name="details_en" class="form-control form-control-sm @error("details_en") is-invalid @enderror" id="detailsEnInput" placeholder="Ex: Enter details">{{ old("details_en") }}</textarea>
                                @error('details_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="detailsBnInput" class="col-md-4 col-form-label col-form-label-sm">Details (Bn)</label>
                            <div class="col-md-8">
                                <textarea name="details_bn" class="form-control form-control-sm @error("details_bn") is-invalid @enderror" id="detailsBnInput" placeholder="Ex: Enter details">{{ old("details_bn") }}</textarea>
                                @error('details_bn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2" hidden>
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="bannerInput" class="col-md-4 col-form-label col-form-label-sm">Banner</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control form-control-sm @error("banner") is-invalid @enderror" name="banner" id="bannerInput" accept="image/jpg,image/jpeg,image/png">
                                    @error('banner')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="bannerPreviewDiv"></div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push("onPageExtraJS")
    <script src="{{ asset("js/jquery.bongabdo.min.js") }}"></script>
    <script>
        $(document).ready(function(){

            $("#dateEnInput").change(function(){
                if( $(this).val().length > 0 ){
                    $('#dateBnInputText').html($(this).val());
                    $('#dateBnInputText').bongabdo();
                    $('#dateBnInput').val($('#dateBnInputText').html());
                }
                else{
                    $('#dateBnInputText').val(null)
                }

            });
        });
    </script>
@endpush
