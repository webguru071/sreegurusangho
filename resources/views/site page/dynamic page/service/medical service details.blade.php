@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
@endphp

@extends('layouts.app')

@section('pageTitle')
    @if ($currentLanguage == "en")
        {{ __("Medicine service") }}
    @endif
    @if ($currentLanguage == "bn")
        {{ __("সেবা") }}
    @endif
@endsection

@section('content')
    <section id="governing_area_wrapper" class="section_padding {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_heading_center ">
                        <h2>
                            @if ($currentLanguage == "en")
                                {{ $staffMember->name_en }}
                            @endif
                            @if ($currentLanguage == "bn")
                                {{ $staffMember->name_bn }}
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="tabs_one_item">
                        <a href="governing-council-details.html">

                            @if (!($staffMember->image == null))
                                <img src="{{ asset("images/staff-member/".$staffMember->image) }}" alt="img">
                            @endif

                            @if ($staffMember->image == null)
                                <img src="{{ asset("images/staff-member/default-member.png") }}" alt="img">
                            @endif

                            <div class="tabs_team_text_one">
                                @if($currentLanguage == "en")
                                    {!! html_entity_decode($staffMember->short_text_en) !!}
                                @endif

                                @if($currentLanguage == "bn")
                                    {!! html_entity_decode($staffMember->short_text_bn) !!}
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="governing_councel_details_wrapper">
                        <div class="governing_councel_item">
                            @if($currentLanguage == "en")
                                {!! html_entity_decode($staffMember->text_en) !!}
                            @endif

                            @if($currentLanguage == "bn")
                                {!! html_entity_decode($staffMember->text_bn) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
