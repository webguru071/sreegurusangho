@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
@endphp

@extends('layouts.app')

@section('pageTitle')
    @if ($currentLanguage == "en")
        {{ __("Council member") }}
    @endif
    @if ($currentLanguage == "bn")
        {{ __("পরিষদ সদস্য") }}
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
                                {{ __($member->member_position) }}
                            @endif
                            @if ($currentLanguage == "bn")
                                {{ __($member->member_position_bn) }}
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="tabs_one_item">
                        <a href="governing-council-details.html">
                            @if (!($member->image == null))
                                <img src="{{ asset("images/council-member/".$member->image) }}" alt="img">
                            @endif

                            @if ($member->image == null)
                                <img src="{{ asset("images/council-member/default-member.png") }}" alt="img">
                            @endif

                            <div class="tabs_team_text_one">
                                @if($currentLanguage == "en")
                                    {!! html_entity_decode($member->short_description_en) !!}
                                @endif

                                @if($currentLanguage == "bn")
                                    {!! html_entity_decode($member->short_description_bn) !!}
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="governing_councel_details_wrapper">
                        <div class="governing_councel_item">
                            @if($currentLanguage == "en")
                                {!! html_entity_decode($member->description_en) !!}
                            @endif

                            @if($currentLanguage == "bn")
                                {!! html_entity_decode($member->description_bn) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
