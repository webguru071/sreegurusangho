@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Dynamic page section') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dynamic.page.index") }}">{{ $dynamicPage->name }}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dynamic.page.section.index",["id" =>$dynamicPage->id]) }}">Section</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')

    @php
        $selectedType = (old("type") == null) ? "Text" : old("type") ;
    @endphp

    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("dynamic.page.section.save",["id" =>$dynamicPage->id]) }}" method="POST" id="pageCreateForm"  name="page_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{ old("name_en") }}"  required>

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
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{ old("name_bn") }}"  required>

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
                            <label class="col-md-4 col-form-label col-form-label-sm">Type</label>

                            <div class="col-md-8">
                                @if (!( ($dynamicPage->template == "Event") || ($dynamicPage->template == "AshramAndMondir") || ($dynamicPage->template == "GoverningCouncil") || ($dynamicPage->template == "VariousBranchesForBoardOfDirectors") || ($dynamicPage->template == "BoardOfDirectorsOfVariousBranches")))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="Text"  @if ($selectedType == "Text") checked @endif>
                                        <label class="form-check-label">Text</label>
                                    </div>
                                @endif

                                @if (!(($dynamicPage->template == "SriGuruSangha") || ($dynamicPage->template == "Contact") || ($dynamicPage->template == "Home")))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="Module" @if ($selectedType == "Module") checked @endif>
                                        <label class="form-check-label">Module</label>
                                    </div>
                                @endif


                                @error('type')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2" id="moduleDiv" @if($selectedType == "Text") style="display:none;"  @endif>
                        <div class="row">
                            <label class="col-md-4 col-form-label col-form-label-sm">Module</label>
                            <div class="col-md-8">
                                <select name="module" class="form-control form-control-sm @error("module") is-invalid @enderror">
                                    <option value="">Select</option>
                                    @foreach ($moduleList as $moduleIndex =>$module)
                                        <option value="{{ $moduleIndex }}" {{ (old('module') == $moduleIndex) ? "selected" :  null }}>{{ $module }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2" id="divText" @if($selectedType == "Module") style="display:none;"  @endif>
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

                @if (!( ($dynamicPage->template == "Event") || ($dynamicPage->template == "AshramAndMondir") || ($dynamicPage->template == "GoverningCouncil") || ($dynamicPage->template == "VariousBranchesForBoardOfDirectors") || ($dynamicPage->template == "BoardOfDirectorsOfVariousBranches")))
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
                @endif

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

            $('#pageCreateForm').on('change','input[name="type"]', function() {
                var radioValue = $(this).val();
                if(radioValue == "Text"){
                    $('#divText').show();
                    $('#moduleDiv').hide();
                }

                if(radioValue == "Module"){
                    $('#divText').hide();
                    $('#moduleDiv').show();
                }
            });
        });

    </script>
@endpush
