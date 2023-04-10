@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Dashboard') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <div class="card-header">{{ __('Index') }}</div>

        <div class="card-body p-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="siteTab" data-bs-toggle="tab" data-bs-target="#siteTabPanel" type="button" role="tab" aria-controls="siteTabPanel" aria-selected="true">Site</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="footerTab" data-bs-toggle="tab" data-bs-target="#footerTabPanel" type="button" role="tab" aria-controls="footerTabPanel" aria-selected="false">Footer</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="topbarTab" data-bs-toggle="tab" data-bs-target="#topbarTabPanel" type="button" role="tab" aria-controls="topbarTabPanel" aria-selected="false">Top bar</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="siteTabPanel" role="tabpanel" aria-labelledby="siteTab" tabindex="0">
                    <div class="m-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%;"><b>{{ __('Site name') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["site_name_en"] }} ({{ $appSetting["site_name_bn"] }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="card">
                                    <div class="card-header"> {{ __('Logo') }}</div>
                                    <div class="card-body p-3">
                                        <img src="{{ asset($siteLogoPublicUrl.$siteLogo) }}" class="img-thumbnail" alt="Logo">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="card">
                                    <div class="card-header"> {{ __('Manu bar Logo') }}</div>
                                    <div class="card-body p-3">
                                        <img src="{{ asset($siteManubarLogoPublicUrl.$siteManubarLogo) }}" class="img-thumbnail" alt="Logo">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header"> {{ __('Fav icon') }}</div>
                                    <div class="card-body p-3">
                                        <img src="{{ asset($siteFaviconPublicUrl.$siteFavicon) }}" class="img-thumbnail" alt="Fav icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="App setting button">
                            <a href="{{ route("dashboard.edit",["settingType"=>"Site"]) }}" type="button" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i> {{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="footerTabPanel" role="tabpanel" aria-labelledby="footerTab" tabindex="0">
                    <div class="m-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%;"><b>{{ __('Footer youtube link') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_youtube_link"] }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Footer twitter link') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_twitter_link"] }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Footer fb link') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_fb_link"] }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Footer linkedin link') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_linkedin_link"] }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Footer bn') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_bn"] }}</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Footer en') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["footer_en"] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="App setting button">
                            <a href="{{ route("dashboard.edit",["settingType"=>"Footer"]) }}" type="button" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i> {{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="topbarTabPanel" role="tabpanel" aria-labelledby="topbarTab" tabindex="0">
                    <div class="m-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%;"><b>{{ __('Topbar sub title') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["topbar_title_en"] }} ({{ $appSetting["topbar_title_bn"] }})</td>
                                    </tr>

                                    <tr>
                                        <td><b>{{ __('Topbar founder') }}</b></td>
                                        <td>:</td>
                                        <td>{{ $appSetting["topbar_founder_en"] }} ({{ $appSetting["topbar_founder_bn"] }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="App setting button">
                            <a href="{{ route("dashboard.edit",["settingType"=>"Topbar"]) }}" type="button" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i> {{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
