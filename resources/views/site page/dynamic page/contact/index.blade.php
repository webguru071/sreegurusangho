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
                <div class="col-lg-6">
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
                <div class="col-lg-6">
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
            </div>
        </div>
    </section>
@endsection
