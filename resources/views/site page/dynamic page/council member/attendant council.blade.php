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
                <div class="col-lg-12">
                    <div class="custom_leftside_navs">
                        <div class="row">

                            <div class="col-lg-3 offset-lg-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    @foreach ($countryAreas as $caIndex => $countryArea)
                                        <button class="nav-link {{ ($caIndex == 0 ) ? 'active' : null }}" id="v-pills-{{ $countryArea->id }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $countryArea->id }}" type="button" role="tab" aria-controls="v-pills-{{ $countryArea->id }}" aria-selected="true">
                                            @if($currentLanguage == "en")
                                                {{ $countryArea->name_en }}
                                            @endif

                                            @if($currentLanguage == "bn")
                                                {{ $countryArea->name_bn }}
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($countryAreas as $caIndex => $countryArea )
                                        <div class="tab-pane fade {{ ($caIndex == 0 ) ? 'show'.'  active' : null }}" id="v-pills-{{$countryArea->id }}" role="tabpanel" aria-labelledby="v-pills-dhaka-tab">
                                            <div class="division_area_local">
                                                <ul>
                                                    @forelse ($countryArea->countryAreas as $perSubA)
                                                        <li>
                                                            <a href="{{ route('member.dynamic.page',["template"=>"BoardOfDirectorsOfVariousBranches",'branch' => $perSubA->id]) }}"><i class="fas fa-map-marker-alt"></i>
                                                                @if($currentLanguage == "en")
                                                                    {{ $perSubA->name_en }}
                                                                @endif

                                                                @if($currentLanguage == "bn")
                                                                    {{$perSubA->name_bn }}
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @empty
                                                        <li>
                                                            @if($currentLanguage == "en")
                                                                {{ __("No branches has been added.") }}
                                                            @endif

                                                            @if($currentLanguage == "bn")
                                                                {{ __("কোন শাখা যোগ করা হয়নি.") }}
                                                            @endif
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
