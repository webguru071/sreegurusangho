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
                            <div class="col-lg-10 offset-lg-1">
                                <div class="tabs_wrapper_one">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">

                                            @foreach ($pageInfo->sections as $rowIndex => $row)
                                                <button class="nav-link {{ ($rowIndex == 0) ? 'active' : null }}" id="nav{{ $row->id }}Tab" data-bs-toggle="tab" data-bs-target="#nav{{ $row->id }}TabDiv" type="button" role="tab" aria-controls="nav{{ $row->id }}Tab" aria-selected="{{ ($rowIndex == 0) ? 'true' : 'false' }}">
                                                    @if($currentLanguage == 'en')
                                                        {{ $row->name_en }}
                                                    @endif

                                                    @if($currentLanguage == 'bn')
                                                        {{ $row->name_bn }}
                                                    @endif
                                                </button>
                                            @endforeach

                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($pageInfo->sections as $rowIndex => $row)
                                <div class="tab-pane fade {{ ($rowIndex == 0) ? 'show'.' active' : null }}" id="nav{{ $row->id }}TabDiv" role="tabpanel" aria-labelledby="nav{{ $row->id }}TabDiv">
                                    @if(!($row->image == null))
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="baba_bioygraphe">
                                                    <img src="{{ asset("images/dynamicpage/".$row->image) }}" alt="{{ $row->image }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-8">
                                                <div class="governing_councel_details_wrapper">
                                                    <div class="governing_councel_item">
                                                        @if($currentLanguage == 'en')
                                                            {!! html_entity_decode($row->text_en) !!}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {!! html_entity_decode($row->text_bn) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($row->image == null)
                                        <div class="row">
                                            <div class="col-lg-8 offset-lg-2">
                                                <div class="governing_councel_details_wrapper">
                                                    <div class="governing_councel_item">
                                                        @if($currentLanguage == 'en')
                                                            {!! html_entity_decode($row->text_en) !!}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {!! html_entity_decode($row->text_bn) !!}
                                                        @endif
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
