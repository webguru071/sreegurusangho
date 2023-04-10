@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
@endphp

@extends('layouts.app')

@section('pageTitle')
    @if($currentLanguage == 'en')
        {{ $pageInfo->title_en }}
    @endif

    @if($currentLanguage == 'bn')
        {{ $pageInfo->title_bn }}
    @endif
@endsection

@section('content')
    <!-- Main Section Area -->
    <section id="governing_area_wrapper" class="section_padding {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_heading_center">
                        <h2>
                            @if($currentLanguage == 'en')
                                {{ $pageInfo->title_en }}
                            @endif

                            @if($currentLanguage == 'bn')
                                {{ $pageInfo->title_bn }}
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs_area_governing_wrapper">
                        <div class="row">
                            <div class="col-lg-10 offset-lg-1">
                                <div class="tabs_wrapper_one">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">

                                            @foreach ($pageInfo->sections as $sIndex =>$service)
                                                <button class="nav-link @if($sIndex == 0) active @endif" id="nav-{{ $service->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $service->id }}" type="button" role="tab" aria-selected="true">

                                                    @if($currentLanguage == 'en')
                                                        {{ $service->name_en }}
                                                    @endif

                                                    @if($currentLanguage == 'bn')
                                                        {{ $service->name_bn }}
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($pageInfo->sections as $sIndex => $service)
                                <div class="tab-pane @if($sIndex == 0) show active @endif fade " id="nav-{{ $service->id }}" role="tabpanel" aria-labelledby="nav-{{ $service->id }}-tab">
                                    @if($service->type == "Text")
                                        <div class="governing_councel_details_wrapper service_wrappers">
                                            <h3>

                                                @if($currentLanguage == 'en')
                                                    {{ $service->name_en }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ $service->name_bn }}
                                                @endif
                                            </h3>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="event_tabel_area service_event_tabel_area">
                                                        @if($currentLanguage == 'en')
                                                            {!! html_entity_decode($service->text_en) !!}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {!! html_entity_decode($service->text_bn) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!($service->type == "Text") && ($service->module == "MedicalService"))
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="governing_councel_details_wrapper service_wrappers">
                                                    <h3>
                                                        @if($currentLanguage == 'en')
                                                            {{ $service->name_en }}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {{ $service->name_bn }}
                                                        @endif
                                                    </h3>
                                                    <div class="row">
                                                        @foreach ($medicalServiceSections as $mSS)
                                                            <div class="col-lg-3">
                                                                <div class="tabs_one_item">
                                                                    @if($currentLanguage == 'en')
                                                                        <a href="{{ route("medical.service.details",["id"=>$mSS->id]) }}">

                                                                            @if (!($mSS->image == null))
                                                                                <img src="{{ asset("images/staff-member/".$mSS->image) }}" alt="img">
                                                                            @endif

                                                                            @if ($mSS->image == null)
                                                                                <img src="{{ asset("images/staff-member/default-member.png") }}" alt="img">
                                                                            @endif
                                                                            <div class="tabs_team_text_one">
                                                                                {!! html_entity_decode($mSS->short_text_en) !!}
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                    @if($currentLanguage == 'bn')
                                                                        <a href="{{ route("medical.service.details",["id"=>$mSS->id]) }}">
                                                                            @if (!($mSS->image == null))
                                                                                <img src="{{ asset("images/staff-member/".$mSS->image) }}" alt="img">
                                                                            @endif

                                                                            @if ($mSS->image == null)
                                                                                <img src="{{ asset("images/staff-member/default-member.png") }}" alt="img">
                                                                            @endif
                                                                            <div class="tabs_team_text_one">
                                                                                {!! html_entity_decode($mSS->short_text_en) !!}
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
