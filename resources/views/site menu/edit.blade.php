@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Site menu') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("site.menu.index") }}">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
@endsection

@section('content')
    @php
        $selectedParent = (old('parent_id') == null) ? $siteMenu->parent_id : old('parent_id');
        $selectedDP = (old('page_id') == null) ? $siteMenu->page_id : old('page_id');
    @endphp
    <div class="card">
        <div class="card-header">{{ __('Edit') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("site.menu.update",["id"=> $siteMenu->id]) }}" method="POST" id="pageCreateForm"  name="page_create" enctype="multipart/form-data">
                @csrf

                @method("PATCH")

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="titleEnInput" class="col-md-4 col-form-label col-form-label-sm">Name (En)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="form-control form-control-sm @error("name_en") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{ (old("name_en") == null ) ?  $siteMenu->name_en : old("name_en"); }}"  required>

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
                            <label for="titleBnInput" class="col-md-4 col-form-label col-form-label-sm">Name (Bn)</label>
                            <div class="col-md-8">
                                <input type="text" name="name_bn" class="form-control form-control-sm @error("name_bn") is-invalid @enderror" placeholder="Ex: Perfect HRM" value="{{  (old("name_bn") == null ) ?  $siteMenu->name_bn : old("name_bn") ;}}"  required>

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
                            <label for="pageInput" class="col-md-4 col-form-label col-form-label-sm">Parent</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm @error("parent_id") is-invalid @enderror" name="parent_id">
                                    <option value="">Select</option>
                                    @foreach ($siteMenus as $siteMenu)
                                        <option value="{{ $siteMenu->id }}" @if ($siteMenu->id == $selectedParent) selected @endif>{{ $siteMenu->name_en }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <label for="pageInput" class="col-md-4 col-form-label col-form-label-sm">Page id</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm @error("page_id") is-invalid @enderror" name="page_id">
                                    <option value="">Select</option>
                                    @foreach ($dynamicPages as $dP)
                                        <option value="{{ $dP->id }}" @if ($dP->id == $selectedDP) selected @endif>{{ $dP->name }}</option>
                                    @endforeach
                                </select>
                                @error('page_id')
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
                            <button type="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
