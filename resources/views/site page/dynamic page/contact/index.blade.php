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

    @include('utility.status messages')

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
                <div class="col-lg-4">
                    <div class="contact_form_area">
                        <form action="{{ route("send.email") }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="first_name" class="form-control" @if($currentLanguage == 'en')  placeholder="First Name" @endif @if($currentLanguage == 'bn')  placeholder="নামের প্রথম অংশ" @endif required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="last_name" class="form-control"  @if($currentLanguage == 'en')  placeholder="Last Name" @endif @if($currentLanguage == 'bn')  placeholder="নামের শেষাংশ" @endif required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" @if($currentLanguage == 'en')  placeholder="Email Address" @endif @if($currentLanguage == 'bn')  placeholder="ইমেইল ঠিকানা" @endif required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" @if($currentLanguage == 'en')  placeholder="Subject" @endif @if($currentLanguage == 'bn')  placeholder="বিষয়" @endif required>
                            </div>
                            <div class="form-group">
                                <textarea name="body" rows="5" class="form-control" @if($currentLanguage == 'en')  placeholder="Type your mesage" @endif @if($currentLanguage == 'bn')  placeholder="আপনার বার্তা টাইপ করুন" @endif required></textarea>
                            </div>
                            <div class="form-submit_btn">
                                <button name="submit" class="btn btn_md btn_theme contact-us-send-button">@if($currentLanguage == 'en')  Send @endif @if($currentLanguage == 'bn')  পাঠান @endif</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact_right_area">
                        @foreach ($pageInfo->sections as $PerCS)
                            <div class="contact_info_box">

                                @if($currentLanguage == 'en')
                                    {!! html_entity_decode($PerCS->text_en) !!}
                                @endif

                                @if($currentLanguage == 'bn')
                                    {!! html_entity_decode($PerCS->text_bn) !!}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="map-area">
                        @if($currentLanguage == 'en')
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3682.6554947961563!2d90.06317016534956!3d22.62933643658773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375554b02e4dcb2f%3A0x874c19c1bbc10df4!2sGuru%20Songho%20Kendrio%20Asrom%2C%20Asrom%20Road%2C%20Kawkhali!5e0!3m2!1sen!2sbd!4v1681197718698!5m2!1sen!2sbd" width="600" height="575" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif

                        @if ($currentLanguage == 'bn')
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52500.9271923128!2d90.0342590332852!3d22.61111155534216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375555f4d9e3a41d%3A0x93dcc13e945ad7c!2z4Ka24KeN4Kaw4KeAIOCml-CngeCmsOCngSDgprjgpoLgppgg4KaV4KeH4Kao4KeN4Kam4KeN4Kaw4KeA4KefIOCmhuCmtuCnjeCmsOCmriwg4KaV4Ka-4KaJ4KaW4Ka-4Kay4KeA!5e0!3m2!1sen!2sbd!4v1681197654644!5m2!1sen!2sbd" width="600" height="575" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
