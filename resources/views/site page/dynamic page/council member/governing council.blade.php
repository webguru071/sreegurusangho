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
                            <div class="col-lg-8 offset-lg-2">
                                <div class="tabs_wrapper_one">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach ($pageInfo->sections as $sIndex =>$section)
                                                <button class="nav-link @if($sIndex == 0) active @endif" id="nav-home-{{ $sIndex }}" data-bs-toggle="tab" data-bs-target="#nav-{{ $sIndex }}" type="button" role="tab" aria-controls="nav-{{ $sIndex }}" aria-selected="true">
                                                    @if ($currentLanguage == "en")
                                                        {{ $section->name_en }}
                                                    @endif
                                                    @if ($currentLanguage == "bn")
                                                        {{ $section->name_bn }}
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($pageInfo->sections as $sIndex => $section)
                                <div class="tab-pane fade show @if($sIndex == 0) active @endif" id="nav-{{ $sIndex }}" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        @if($section->type == "Module")
                                            @if($section->module == "HonorableAdvisoryCouncil")

                                                @foreach ($honorableAdvisoryCouncils as $perHAC)
                                                    <div class="col-lg-3">
                                                        <div class="tabs_one_item">
                                                            <a href="{{ route("council.member.info.page",["id"=>$perHAC->id]) }}">

                                                                @if (!($perHAC->image == null))
                                                                    <img src="{{ asset("images/council-member/".$perHAC->image) }}" alt="img">
                                                                @endif

                                                                @if ($perHAC->image == null)
                                                                    <img src="{{ asset("images/council-member/default-member.png") }}" alt="img">
                                                                @endif
                                                                <div class="tabs_team_text_one">
                                                                    <h3>
                                                                        @if($currentLanguage == "en")
                                                                            {{ $perHAC->name_en }}
                                                                        @endif

                                                                        @if($currentLanguage == "bn")
                                                                            {{ $perHAC->name_bn }}
                                                                        @endif
                                                                    </h3>
                                                                    @if($currentLanguage == "en")
                                                                        {!! html_entity_decode($perHAC->short_description_en) !!}
                                                                    @endif

                                                                    @if($currentLanguage == "bn")
                                                                        {!! html_entity_decode($perHAC->short_description_bn) !!}
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if($section->module == "AttendantAssociationCouncil")
                                                @foreach ($attendantAssociationCouncils as $perHEC)
                                                    <div class="col-lg-3">
                                                        <div class="tabs_one_item">
                                                            <a href="{{ route("council.member.info.page",["id"=>$perHEC->id]) }}">
                                                                @if (!($perHEC->image == null))
                                                                    <img src="{{ asset("images/council-member/".$perHEC->image) }}" alt="img">
                                                                @endif

                                                                @if ($perHEC->image == null)
                                                                    <img src="{{ asset("images/council-member/default-member.png") }}" alt="img">
                                                                @endif
                                                                <div class="tabs_team_text_one">
                                                                    <h3>
                                                                        @if($currentLanguage == "en")
                                                                            {{ $perHEC->name_en }}
                                                                        @endif

                                                                        @if($currentLanguage == "bn")
                                                                            {{ $perHEC->name_bn }}
                                                                        @endif
                                                                    </h3>
                                                                    @if($currentLanguage == "en")
                                                                        {!! html_entity_decode($perHEC->short_description_en) !!}
                                                                    @endif

                                                                    @if($currentLanguage == "bn")
                                                                        {!! html_entity_decode($perHEC->short_description_bn) !!}
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
