@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
@endphp

@extends('layouts.app')

@section('pageTitle')
    @if ($currentLanguage == "en")
        {{ $pageInfo->title_en }}
    @endif

    @if ($currentLanguage == "bn")
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
                            @if ($currentLanguage == "en")
                                {{ $pageInfo->title_en }}
                            @endif

                            @if ($currentLanguage == "bn")
                                {{ $pageInfo->title_bn }}
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="custom_leftside_navs">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">

                                    @foreach($aamCountryAreas as $perAMMCAIndex => $perAMMCA)
                                        <button class="nav-link @if( $perAMMCAIndex == 0) active @endif" id="v-pills-{{ $perAMMCA->id }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-{{ $perAMMCA->id }}" type="button" role="tab"
                                        aria-controls="v-pills-{{ $perAMMCA->id }}" aria-selected="true">
                                            @if($currentLanguage == 'en')
                                                {{ $perAMMCA->name_en }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ $perAMMCA->name_bn }}
                                            @endif
                                        </button>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach($aamCountryAreas as $perAMMCAIndex => $perAMMCA)
                                        <div class="tab-pane fade @if( $perAMMCAIndex == 0) show active @endif" id="v-pills-{{ $perAMMCA->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $perAMMCA->id }}-tab">
                                            @foreach ($aamList[$perAMMCA->id] as $row)
                                                <div class="governing_councel_details_wrapper">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mondir_img">
                                                                <img src="{{ asset("images/mondir-and-ashram/".$row->image) }}" alt="img">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <div class="mondir_text">
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
                                            @endforeach
                                        </div>
                                    @endforeach

                                    {{-- <div class="tab-pane fade show active" id="v-pills-dhaka" role="tabpanel"
                                        aria-labelledby="v-pills-dhaka-tab">

                                        @foreach ($dhakaAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-rangpur" role="tabpanel"
                                        aria-labelledby="v-pills-rangpur-tab">

                                        @foreach ($rangpurAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-barisal" role="tabpanel"
                                        aria-labelledby="v-pills-barisal-tab">

                                        @foreach ($barisalAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-chittagong" role="tabpanel"
                                        aria-labelledby="v-pills-chittagong-tab">

                                        @foreach ($chittagongAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-khulna" role="tabpanel"
                                        aria-labelledby="v-pills-khulna-tab">

                                        @foreach ($khulnaAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-rajshahi" role="tabpanel"
                                        aria-labelledby="v-pills-rajshahi-tab">

                                        @foreach ($rajshahiAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-sylhet" role="tabpanel"
                                        aria-labelledby="v-pills-sylhet-tab">

                                        @foreach ($sylhetAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div>
                                    <div class="tab-pane fade" id="v-pills-mymensingh" role="tabpanel"
                                        aria-labelledby="v-pills-mymensingh-tab">

                                        @foreach ($mymensinghAAMS as $row)
                                            <div class="governing_councel_details_wrapper">
                                                <div class="row mb-2">
                                                    <div class="col-lg-4">
                                                        <div class="mondir_img">
                                                            <img src="{{ asset("images/page/".$row->image) }}" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="mondir_text">
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
                                        @endforeach

                                    </div> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
