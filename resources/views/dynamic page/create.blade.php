@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Page') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dynamic.page.index") }}">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("dynamic.page.save") }}" method="POST" id="pageCreateForm"  name="page_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameInput" class="col-md-4 col-form-label col-form-label-sm">Name</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control form-control-sm @error("name") is-invalid @enderror" id="nameEnInput" placeholder="Ex: Perfect HRM" value="{{ old("name") }}"  required>

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
                            <label for="templateInput" class="col-md-4 col-form-label col-form-label-sm">Template</label>
                            <div class="col-md-8">

                                <select class="form-control form-control-sm @error("template") is-invalid @enderror" name="template" required>
                                    <option value="">Select</option>
                                    @foreach ($templateList as $templateIndex => $template)
                                        <option value="{{ $templateIndex }}" @if ($templateIndex == old("template")) selected @endif>{{ $template }}</option>
                                    @endforeach
                                </select>
                                @error('template')
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
                            <label for="titleEnInput" class="col-md-4 col-form-label col-form-label-sm">Title (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="title_en" class="form-control form-control-sm @error("title_en") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{ old("title_en") }}"  required>

                                @error('title_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Title (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="title_bn" class="form-control form-control-sm @error("title_bn") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{ old("title_bn") }}"  required>

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
                            <label for="subTitleEnInput" class="col-md-4 col-form-label col-form-label-sm">Sub title (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="sub_title_en" class="form-control form-control-sm @error("sub_title_en") is-invalid @enderror" id="subTitleEnInput" placeholder="Ex: Perfect HRM" value="{{ old("sub_title_en") }}" >

                                @error('sub_title_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="sub_titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Sub title (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="sub_title_bn" class="form-control form-control-sm @error("sub_title_bn") is-invalid @enderror" id="subTitleBnInput" placeholder="Ex: Perfect HRM" value="{{ old("sub_title_bn") }}">

                                @error('sub_title_bn')
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
                            <label for="textEnInput" class="col-md-4 col-form-label col-form-label-sm">Text (En)</label>
                            <div class="col-md-8">
                                <textarea name="text_en" class="form-control form-control-sm tinymce-text-area @error("text_en") is-invalid @enderror" id="textEnInput" placeholder="Ex: Enter text">{{ old("text_en") }}</textarea>
                                @error('text_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="textBnInput" class="col-md-4 col-form-label col-form-label-sm">Text (Bn)</label>
                            <div class="col-md-8">
                                <textarea name="text_bn" class="form-control form-control-sm tinymce-text-area @error("text_bn") is-invalid @enderror" id="textBnInput" placeholder="Ex: Enter text">{{ old("text_bn") }}</textarea>
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
                selector: '.tinymce-text-area',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });
        });

    </script>
@endpush
