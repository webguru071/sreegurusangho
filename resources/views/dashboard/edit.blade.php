@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Dashboard') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dashboard.index") }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')
    @php
        $siteLogo = $appSetting["logo"];
        $siteLogoPublicUrl = "images/setting/app/";

        $siteManubarLogo = $appSetting["manubar_logo"];
        $siteManubarLogoPublicUrl = "images/setting/app/";

        $siteFavicon = $appSetting["favicon"];
        $siteFaviconPublicUrl = "images/setting/app/";

        if((($appSetting["logo"] == "default-logo.png") || ($appSetting["logo"] == null)) && !(file_exists(asset($siteLogoPublicUrl. $appSetting["logo"] ) ) ) ){
            $siteLogo = "default-logo.png";
        }

        if(( ($appSetting["manubar_logo"] == "default-manubar-logo.png") || ($appSetting["manubar_logo"] == null) ) && !(file_exists(asset($siteManubarLogoPublicUrl. $appSetting["manubar_logo"] ) ) ) ){
            $siteManubarLogo = "default-manubar-logo.png";
        }

        if((($appSetting["favicon"] == "default-favicon.png") || ($appSetting["favicon"] == null)) && !(file_exists(asset($siteFaviconPublicUrl. $appSetting["favicon"] ) ) ) ){
            $siteFavicon ="default-favicon.png";
        }
    @endphp

    <div class="card">
        <div class="card-header">{{ __('Edit') }}</div>

        <div class="card-body p-3">
            <form action="{{ route("dashboard.update",["settingType"=>$settingType]) }}" method="POST" enctype="multipart/form-data" name="app_setting_update">
                @csrf
                @method("PATCH")

                @if ($settingType =="Site")
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="siteNameEnInput" class="col-md-4 col-form-label col-form-label-sm">Site name (En)</label>
                                <div class="col-md-8">
                                    <input type="text" name="site_name_en" class="form-control form-control-sm @error("site_name_en") is-invalid @enderror" id="siteNameEnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("site_name_en") == null ) ? $appSetting["site_name_en"] : old("site_name_en") }}" maxlength="15">

                                    @error('site_name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="siteNameBnInput" class="col-md-4 col-form-label col-form-label-sm">Site name (Bn)</label>
                                <div class="col-md-8">
                                    <input type="text" name="site_name_bn" class="form-control form-control-sm @error("site_name_bn") is-invalid @enderror" id="siteNameBnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("site_name_bn") == null ) ? $appSetting["site_name_bn"] : old("site_name_bn") }}" maxlength="15">

                                    @error('site_name_bn')
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
                                <label for="logoInput" class="col-md-4 col-form-label col-form-label-sm">Logo</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control form-control-sm demo @error("logo") is-invalid @enderror" name="logo" id="logoInput" accept="image/jpg,image/jpeg,image/png">
                                    @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="logoPreviewDiv">
                            <img src="{{ asset($siteLogoPublicUrl.$siteLogo) }}" class="img-thumbnail" alt="Logo">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="manubarLogoInput" class="col-md-4 col-form-label col-form-label-sm">Meanu bar Logo</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control form-control-sm demo @error("manubar_logo") is-invalid @enderror" name="manubar_logo" id="manubarLogoInput" accept="image/jpg,image/jpeg,image/png">
                                    @error('manubar_logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="manubarLogoPreviewDiv">
                            <img src="{{ asset($siteManubarLogoPublicUrl.$siteManubarLogo) }}" class="img-thumbnail" alt="Logo">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="faviconInput" class="col-md-4 col-form-label col-form-label-sm">Favicon</label>
                                <div class="col-md-8 ">
                                    <input type="file" class="form-control form-control-sm demo @error("favicon") is-invalid @enderror" name="favicon" id="faviconInput" accept="image/jpg,image/jpeg,image/png,.ico">
                                    <span>Size must be 16x16px.</span>
                                    @error('favicon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2" class="jpreview-container" id="faviconPreviewDiv">
                            <img src="{{ asset($siteFaviconPublicUrl.$siteFavicon) }}" class="img-thumbnail" alt="Fav icon">
                        </div>
                    </div>
                @endif

                @if ($settingType == "Topbar")
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="topbarFounderEnInput" class="col-md-4 col-form-label col-form-label-sm">Topbar founder (En)</label>
                                <div class="col-md-8">
                                    <input type="text" name="topbar_founder_en" class="form-control form-control-sm @error("topbar_founder_en") is-invalid @enderror" id="topbarFounderEnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("topbar_founder_en") == null ) ? $appSetting["topbar_founder_en"] : old("topbar_founder_en") }}">

                                    @error('topbar_founder_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="topbarFounderBnInput" class="col-md-4 col-form-label col-form-label-sm">Topbar founder (Bn)</label>
                                <div class="col-md-8">
                                    <input type="text" name="topbar_founder_bn" class="form-control form-control-sm @error("topbar_founder_bn") is-invalid @enderror" id="topbarFounderBnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("topbar_founder_bn") == null ) ? $appSetting["topbar_founder_bn"] : old("topbar_founder_bn") }}">

                                    @error('topbar_founder_bn')
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
                                <label for="topbarTitleEnInput" class="col-md-4 col-form-label col-form-label-sm">Topbar title  (En)</label>
                                <div class="col-md-8">
                                    <input type="text" name="topbar_title_en" class="form-control form-control-sm @error("topbar_title_en") is-invalid @enderror" id="topbarTitleEnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("topbar_title_en") == null ) ? $appSetting["topbar_title_en"] : old("topbar_title_en") }}">

                                    @error('topbar_title_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="topbarTitleBnInput" class="col-md-4 col-form-label col-form-label-sm">Topbar title  (Bn)</label>
                                <div class="col-md-8">
                                    <input type="text" name="topbar_title_bn" class="form-control form-control-sm @error("topbar_title_bn") is-invalid @enderror" id="topbarTitleBnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("topbar_title_bn") == null ) ? $appSetting["topbar_title_bn"] : old("topbar_title_bn") }}">

                                    @error('topbar_title_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($settingType == "Footer")
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="footerYoutubLinkInput" class="col-md-4 col-form-label col-form-label-sm">Footer youtube link</label>
                                <div class="col-md-8">
                                    <input type="url" name="footer_youtube_link" class="form-control form-control-sm @error("footer_youtube_link") is-invalid @enderror" id="footerYoutubLinkInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_youtube_link") == null ) ? $appSetting["footer_youtube_link"] : old("footer_youtube_link") }}">

                                    @error('footer_youtube_link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="footerFbLinkInput" class="col-md-4 col-form-label col-form-label-sm">Footer fb link</label>
                                <div class="col-md-8">
                                    <input type="url" name="footer_fb_link" class="form-control form-control-sm @error("footer_fb_link") is-invalid @enderror" id="footerFbLinkInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_fb_link") == null ) ? $appSetting["footer_fb_link"] : old("footer_fb_link") }}">

                                    @error('footer_fb_link')
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
                                <label for="footerTwitterLinkInput" class="col-md-4 col-form-label col-form-label-sm">Footer twitter link</label>
                                <div class="col-md-8">
                                    <input type="text" name="footer_twitter_link" class="form-control form-control-sm @error("footer_twitter_link") is-invalid @enderror" id="topbarLogoRightEnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_twitter_link") == null ) ? $appSetting["footer_twitter_link"] : old("footer_twitter_link") }}">

                                    @error('footer_twitter_link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="footerLinkedinLinkInput" class="col-md-4 col-form-label col-form-label-sm">Footer linkedin link</label>
                                <div class="col-md-8">
                                    <input type="text" name="footer_linkedin_link" class="form-control form-control-sm @error("footer_linkedin_link") is-invalid @enderror" id="topbarLogoRightBnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_linkedin_link") == null ) ? $appSetting["footer_linkedin_link"] : old("footer_linkedin_link") }}">

                                    @error('footer_linkedin_link')
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
                                <label for="footerEnInput" class="col-md-4 col-form-label col-form-label-sm">Footer (En)</label>
                                <div class="col-md-8">
                                    <input type="text" name="footer_en" class="form-control form-control-sm @error("footer_en") is-invalid @enderror" id="footerEnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_en") == null ) ? $appSetting["footer_en"] : old("footer_en") }}">

                                    @error('footer_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="footerBnLinkInput" class="col-md-4 col-form-label col-form-label-sm">Footer (Bn)</label>
                                <div class="col-md-8">
                                    <input type="text" name="footer_bn" class="form-control form-control-sm @error("footer_bn") is-invalid @enderror" id="footerBnInput" placeholder="Ex: Perfect HRM" value="{{ ( old("footer_bn") == null ) ? $appSetting["footer_bn"] : old("footer_bn") }}">

                                    @error('footer_bn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-outline-success">Update</button>
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
            $("#logoInput").on("change",function(){
                var $input = $(this);
                if($(this).val()){
                    var reader = new FileReader();
                    reader.onload = function(){
                        $("#logoPreviewDiv img").attr("src", reader.result);
                    }
                    reader.readAsDataURL($input[0].files[0]);
                }
                else{
                    $("#logoPreviewDiv img").attr("src", "{{ asset($siteLogoPublicUrl.$siteLogo) }}");
                }
            });
            $("#faviconInput").on("change",function(){
                var $input = $(this);
                if($(this).val()){
                    var reader = new FileReader();
                    reader.onload = function(){
                        $("#faviconPreviewDiv img").attr("src", reader.result);
                    }
                    reader.readAsDataURL($input[0].files[0]);
                }
                else{
                    $("#faviconPreviewDiv img").attr("src", "{{ asset($siteFaviconPublicUrl.$siteFavicon) }}");
                }
            });
        });
    </script>
@endpush
