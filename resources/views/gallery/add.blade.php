@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Gallery') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("gallery.index") }}">Home slider</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("gallery.save") }}" method="POST"  name="gallery_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="titleEnInput" class="col-md-4 col-form-label col-form-label-sm">Title (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="title_en" class="form-control form-control-sm @error("title_en") is-invalid @enderror" id="titleEnInput" placeholder="Ex: Perfect HRM" value="{{ old("title_en") }}" required>

                                @error('title_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Title (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="title_bn" class="form-control form-control-sm @error("title_bn") is-invalid @enderror" id="titleBnInput" placeholder="Ex: Perfect HRM" value="{{ old("title_bn") }}" required>

                                @error('title_bn')
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
                            <label for="typeInput" class="col-md-4 col-form-label col-form-label-sm">Type</label>
                            <div class="col-md-8">
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="typeImageRadio" value="Image" checked>
                                        <label class="form-check-label" for="typeImageRadio">Image</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="typeVideoRadio" value="Video">
                                        <label class="form-check-label" for="typeVideoRadio">Video</label>
                                    </div>
                                </div>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="imagePreviewDiv"></div>
                </div>


                <div class="row mb-2" id="imageGalleryItemDiv">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="imageInput" class="col-md-4 col-form-label col-form-label-sm">Image</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control form-control-sm @error("image") is-invalid @enderror" name="image" id="imageInput" accept="image/jpg,image/jpeg,image/png">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="imagePreviewDiv"></div>
                </div>

                <div class="row mb-2" id="videoGalleryDiv" style="display: none;">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="videoUrlInput" class="col-md-4 col-form-label col-form-label-sm">Url</label>
                            <div class="col-md-8">
                                <input type="url" class="form-control form-control-sm  @error("video_url") is-invalid @enderror" name="video_url" id="videoUrlInput" placeholder="Ex: url" readonly>
                                @error('video_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="videoUrlPreviewDiv"></div>
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
    <script>
        $(document).ready(function(){
            $("input[name='type']").click(function(){
                var typeOption = $(this).val();
                if(typeOption == "Image"){
                    $("#imageGalleryItemDiv").show();
                    $("#imageInput").show();
                    $("#imageInput").prop("disabled",false);
                    $("#imageInput").prop("required",false);

                    $("#videoGalleryDiv").hide();
                    $("#videoUrlInput").prop("disabled",true);
                    $("#videoUrlInput").prop("required",true);
                    $("#videoUrlInput").prop("readonly",true);
                }

                if(typeOption == "Video"){
                    $("#videoGalleryDiv").show();
                    $("#videoUrlInput").prop("disabled",false);
                    $("#videoUrlInput").prop("required",false);
                    $("#videoUrlInput").prop("readonly",false);

                    $("#imageGalleryItemDiv").hide();
                    $("#imageInput").hide();
                    $("#imageInput").prop("disabled",true);
                    $("#imageInput").prop("required",true);
                }
            });
        });


    </script>
@endpush
