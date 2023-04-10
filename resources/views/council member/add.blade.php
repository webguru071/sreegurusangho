@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Council member') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("council.member.index") }}">Council member</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')

    @php
        $council = old("council");
        $branch = (old("branch") == null) ? null : old("branch");
        $membershipType = old("membership_type");

        if($council == null){
            $council = "Honorable governing council";
        }

        if($membershipType == null){
            $membershipType = "Honorable advisory council";
        }

    @endphp

    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("council.member.save") }}" method="POST"  name="council_member_create" enctype="multipart/form-data">
                @csrf

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="titleEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" id="titleEnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_en") }}" required>

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
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" id="titleBnInput" placeholder="Ex: Perfect HRM" value="{{ old("name_bn") }}" required>

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
                            <label for="councilInput" class="col-md-4 col-form-label col-form-label-sm">Council</label>
                            <div class="col-md-8">

                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="council" id="councilRadio2" value="Honorable governing council" @if($council == "Honorable governing council") checked @endif>
                                        <label class="form-check-label" for="councilRadio2">Honorable Governing Council</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="council" id="councilRadio3" value="Board of director" @if($council == "Board of director") checked @endif>
                                        <label class="form-check-label" for="councilRadio3">Board of director</label>
                                    </div>
                                </div>
                                @error('council')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="branchInputDiv" @if($council == "Honorable governing council") style="display: none;" @endif>
                        <div class="row">
                            <label class="col-lg-4 col-form-label col-form-label-sm text-bold">Branch</label>
                            <div class="col-lg-8">
                                <select id="branchInput" name="branch" class="form-control form-control-sm @error('branch') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <x-council_member.form.countryareas :countryAreas="$branches" :selectedId="$branch"/>
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

                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        <div class="row">
                            <label for="membershipTypeInput" class="col-md-2 col-form-label col-form-label-sm">Membership type</label>
                            <div class="col-md-10">

                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membership_type" id="membershipTypeRadio1" value="Honorable advisory council" @if($membershipType == "Honorable advisory council") checked @endif>
                                        <label class="form-check-label" for="membershipTypeRadio2">Honorable advisory council</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membership_type" id="membershipTypeRadio2" value="Attendant association council" @if($membershipType == "Attendant association council") checked @endif>
                                        <label class="form-check-label" for="membershipTypeRadio3">Attendant association council</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="membership_type" id="membershipTypeRadio3" value="Honorable executive council" @if($membershipType == "Honorable executive council") checked @endif>
                                        <label class="form-check-label" for="membershipTypeRadio3">Honorable executive council</label>
                                    </div>
                                </div>
                                @error('membership_main_type')
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
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Member position (en)</label>
                            <div class="col-md-8">
                                <input type="text" name="member_position" class="form-control form-control-sm @error("member_position") is-invalid @enderror" id="memberPositionInput" placeholder="Ex: Perfect HRM" value="{{ old("member_position") }}">

                                @error('member_position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Member position (bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="member_position_bn" class="form-control form-control-sm @error("member_position_bn") is-invalid @enderror" id="memberPositionBnInput" placeholder="Ex: Perfect HRM" value="{{ old("member_position_bn") }}">

                                @error('member_position_bn')
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
                            <label for="shortDescriptionEnInput" class="col-md-4 col-form-label col-form-label-sm">Short description (En)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm short-description" name="short_description_en" id="shortDescriptionEnInput" ></textarea>
                                @error('short_description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="shortDescriptionBnInput" class="col-md-4 col-form-label col-form-label-sm">Short description (Bn)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm short-description" name="short_description_bn" id="shortDescriptionBnInput" ></textarea>
                                @error('short_description_bn')
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
                            <label for="descriptionEnInput" class="col-md-4 col-form-label col-form-label-sm">Description (En)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm full-description" name="description_en" id="descriptionEnInput"></textarea>
                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label for="descriptionBnInput" class="col-md-4 col-form-label col-form-label-sm">Description (Bn)</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm full-description" name="description_bn" id="descriptionBnInput"></textarea>
                                @error('description_bn')
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
                selector: '.short-description',
                height: 350,

                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });

            tinymce.init({
                selector: '.full-description',
                height: 350,

                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: false,
            });

            $('input:radio[name=council]').change(function () {
                var councilValue = $(this).val();
                if (councilValue == 'Board of director') {
                    $("#branchInputDiv").show();
                }

                if (councilValue == 'Honorable governing council') {
                    $("#branchInputDiv").hide();
                }

            });
        });

    </script>
@endpush
