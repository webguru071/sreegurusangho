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
                    <div class="asram_all_event_wrapper">
                        <div class="event_top_header">
                            @if($currentLanguage == 'en')
                                <h2> {{ $pageInfo->sub_title_en }}</h2>
                                {!! html_entity_decode($pageInfo->text_en) !!}
                            @endif

                            @if($currentLanguage == 'bn')
                                <h2> {{ $pageInfo->sub_title_bn }}</h2>
                                {!! html_entity_decode($pageInfo->text_bn) !!}
                            @endif

                        </div>
                        <div class="event_tabel_area">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            @if($currentLanguage == 'en') Bangla / English Date @endif
                                            @if($currentLanguage == 'bn') বাংলা/ইংরেজি তারিখ @endif
                                        </th>
                                        <th>
                                            @if($currentLanguage == 'en') Day @endif
                                            @if($currentLanguage == 'bn') দিন @endif
                                        </th>
                                        <th>
                                            @if($currentLanguage == 'en') Events @endif
                                            @if($currentLanguage == 'bn') অনুষ্ঠানাদি @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                        <tr>
                                            <td>
                                                {{ $event->date_bn }}
                                            </td>
                                            <td>{{ GoogleTranslate::trans( date("d-M-Y",strtotime($event->date_en)), $currentLanguage ) }}</td>
                                            <td>
                                                @if($currentLanguage == 'en') {{ $event->day_en }} @endif
                                                @if($currentLanguage == 'bn') {{ $event->day_bn }} @endif
                                            </td>
                                            <td>
                                                @if($currentLanguage == 'en') {{ $event->name_en }} @endif
                                                @if($currentLanguage == 'bn') {{ $event->name_bn }} @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                @if($currentLanguage == 'en')
                                                    {{ __("No events are available") }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
