@php
    $nameEn = (old('name_en') == null) ? $mondirAndAshram->name_en : old('name_en');
    $nameBn = (old('name_bn') == null) ? $mondirAndAshram->name_bn : old('name_bn');
    $branch = old("branch");

    $textEn = (old('text_en') == null) ? $mondirAndAshram->text_en : old('text_en');
    $textBn = (old('text_bn') == null) ? $mondirAndAshram->text_bn : old('text_bn');

    if( $branch == null){
        $branch = $mondirAndAshram->branch;
    }
@endphp


@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Council member') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("mondir.and.ashram.index") }}">Council member</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Edit') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("mondir.and.ashram.update",["id" => $mondirAndAshram->id]) }}" method="POST"  name="council_member_edit" enctype="multipart/form-data">
                @csrf
                @method("PATCH")

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="titleEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" id="titleEnInput" placeholder="Ex: Perfect HRM" value="{{ $nameEn }}" required>

                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Name (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" id="titleBnInput" placeholder="Ex: Perfect HRM" value="{{ $nameBn }}" required>

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
                    <div class="col-md-6">
                        <div class="row">
                            <label for="councilInput" class="col-md-4 col-form-label col-form-label-sm">Branch</label>
                            <div class="col-md-8">
                                <div class="col-lg-8">
                                    <select id="branchInput" name="branch" class="form-control form-control-sm @error('branch') is-invalid @enderror">
                                        <option value="">Select</option>
                                        @foreach ($branches as $perB)
                                            <option value="{{ $perB->id }}" @if($branch == $perB->id) selected @endif>{{ $perB->name_en }}</option>
                                        @endforeach
                                    </select>

                                    @error('branch')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="textEnInput" class="col-md-4 col-form-label col-form-label-sm">Text (En)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm full-text" name="text_en" id="textEnInput">{{ $textEn }}</textarea>
                                @error('text_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="textBnInput" class="col-md-4 col-form-label col-form-label-sm">Text (Bn)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm full-text" name="text_bn" id="textBnInput">{{ $textBn }}</textarea>
                                @error('text_bn')
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
    <script src="{{ asset("js/tinymce/js/tinymce/tinymce.min.js") }}"></script>
    <script>
        $(document).ready(function(){
            tinymce.init({
                selector: '.short-text',
                height: 350,

                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });

            tinymce.init({
                selector: '.full-text',
                height: 350,

                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });
        });

    </script>
@endpush
