@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Edit') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("country.area.index") }}">Divisional area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')


    @php
        $hasAParentOptionCheckedStatus = "Yes";
        $selectedId = (old("parent") == null) ? (($countryArea->parent_id == null) ? null : $countryArea->parent_id ) : old("parent") ;
        if($countryArea->parent_id == null){
            if(old("has_a_parent") == null){
                $hasAParentOptionCheckedStatus = "No";
            }
            else{
                if((old("has_a_parent") == "Yes")){
                    $hasAParentOptionCheckedStatus = "Yes";
                }
                else{
                    $hasAParentOptionCheckedStatus = "No";
                }
            }
        }
        else{
            if(old("has_a_parent") == null){
                $hasAParentOptionCheckedStatus = "Yes";
            }
            else{
                if((old("has_a_parent") == "Yes")){
                    $hasAParentOptionCheckedStatus = "Yes";
                }
                else{
                    $hasAParentOptionCheckedStatus = "No";
                }
            }
        }
    @endphp

    <div class="card">
        <div class="card-header">{{ __('Add') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("country.area.update",["id" => $countryArea->id]) }}" method="POST"  name="country_area_add" enctype="multipart/form-data" id="editForm">
                @csrf
                @method("PATCH")

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="nameEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" id="nameEnInput" placeholder="Ex: Perfect HRM" value="{{ (old("name_en") == null) ? $countryArea->name_en : old("name_en") }}"  required>

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
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" id="nameBnInput" placeholder="Ex: Perfect HRM" value="{{ (old("name_bn") == null) ? $countryArea->name_bn :  old("name_bn")}}"  required>

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
                            <label class="col-lg-4 col-form-label col-form-label-sm text-bold">Has a parent</label>
                            <div class="col-lg-8 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="hasAParentInputYesOption" name="has_a_parent" value="Yes" {{ ($hasAParentOptionCheckedStatus == "Yes") ? "checked" : null }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="hasAParentInputNoOption" name="has_a_parent" value="No" {{ ($hasAParentOptionCheckedStatus == "No") ? "checked" : null}}>
                                    <label class="form-check-label">No</label>
                                </div>
                                @error('has_a_parent')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mb-2" id="parentInputDiv" @if ($hasAParentOptionCheckedStatus == "No") style="display: none" @endif>
                    <div class="col-md-12 mb-2">
                        <div class="row">
                            <label class="col-lg-4 col-form-label text-bold">Parent <i class="fa-solid fa-asterisk mt-2" style="font-size: 10px;!important"></i></label>
                            <div class="col-lg-8">
                                <select id="parentInput" name="parent" class="form-control form-control-sm @error('parent') is-invalid @enderror" @if ($hasAParentOptionCheckedStatus == "No") hidden disabled @endif @if ($hasAParentOptionCheckedStatus == "Yes") required @endif>
                                    <option value="">Select</option>
                                    @foreach ($countryAreas as $perCArea)
                                        <option value="{{ $perCArea->id }}" {{ ( $perCArea->id == $selectedId) ? 'selected' : null  }}>{{ $perCArea->name_en }} ({{ $perCArea->name_bn }})</option>
                                    @endforeach
                                    {{-- <x-country_area.form.countryareas :countryAreas="$countryAreas" :selectedId="$selectedId"/> --}}
                                </select>

                                @error('parent')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
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
            $(document).on('change', "#editForm input[type=radio][name=has_a_parent]", function () {
                if (this.value == 'Yes') {
                    $("#parentInputDiv").show();
                    $("#parentInput").prop("hidden",false);
                    $("#parentInput").prop("disabled",false);
                    $("#parentInput").prop("readonly",false);
                    $("#parentInput").prop("required",true);
                }
                if (this.value == 'No') {
                    $("#parentInputDiv").hide();
                    $("#parentInput").prop("hidden",true);
                    $("#parentInput").prop("disabled",true);
                    $("#parentInput").prop("readonly",true);
                    $("#parentInput").prop("required",false);
                }
            });
        });
    </script>
@endpush
