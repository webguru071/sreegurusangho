@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Donate account') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("donate.account.index") }}">Donate account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("donate.account.save") }}" method="POST"  name="donate_account_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" id="nameEnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_en") }}" >

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
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" id="nameBnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_bn") }}">

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
                            <label for="accountEnInput" class="col-md-4 col-form-label col-form-label-sm">Account (En)</label>
                            <div class="col-md-8">
                                <textarea name="account_en" class="form-control form-control-sm description @error("account_en") is-invalid @enderror" id="accountEnInput">{{ old("account_en") }}</textarea>
                                @error('account_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="accountBnInput" class="col-md-4 col-form-label col-form-label-sm">Account (Bn)</label>
                            <div class="col-md-8">
                                <textarea name="account_bn" class="form-control form-control-sm description @error("account_bn") is-invalid @enderror" id="accountBnInput">{{ old("account_bn") }}</textarea>
                                @error('account_bn')
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
                selector: '.description',
                height: 350,

                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });
        });

    </script>
@endpush
