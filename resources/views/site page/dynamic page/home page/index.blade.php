@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
@endphp

@extends('layouts.app')

@section('pageTitle')
    @if($currentLanguage == 'en')
    {{ __('Home') }}
    @endif

    @if($currentLanguage == 'bn')
        {{ __("হোম") }}
    @endif
@endsection

@php
    $monthList = array(
        "01" => 'পৌষ',
        "02" => 'মাঘ',
        "03" => 'ফাল্গুন',
        "04" => 'চৈত্র',
        "05" => 'বৈশাখ',
        "06" => 'জ্যৈষ্ঠ',
        "07" => 'আষাঢ়',
        "08" => 'শ্রাবণ',
        "09" => 'ভাদ্র',
        "10" => 'আশ্বিন',
        "11" => 'কার্তিক',
        "12" => 'অগ্রহায়ণ',
    );
    function showCurrentMonthCalenderViewHome($current_Month, $year){
        $daysBn = array(
            "1" => "১","2" => "২",
            "3" => "৩","4" => "৪",
            "5" => "৫","6" => "৬",
            "7" => "৭","8" => "৮",
            "9" => "৯","10" => "১০",
            "11" => "১১","12" => "১২",
            "13" => "১৩","14" => "১৪",
            "15" => "১৫","16" => "১৬",
            "17" => "১৭","18" => "১৮",
            "19" => "১৯","20" => "২০",
            "21" => "২১","22" => "২২",
            "23" => "২৩","24" => "২৪",
            "25" => "২৫","26" => "২৬",
            "27" => "২৭","28" => "২৮",
            "29" => "২৯","30" => "৩০",
            "31" => "৩১",
        );
        $date = mktime(12, 0, 0, $current_Month, 1, $year);
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN,$current_Month, $year);
        $offset = date("w", $date);
        $row_number = 1;
        // time to draw the month header

        echo "<table class='table table-bordered' width='100%'>";
        //echo "<tr><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr><tr>";
        echo '<tr>
                <td style="width: 10%;">

                    <input type="text" hidden id="priviousMonthInput" value="'.now()->subMonth(1)->format("m-Y").'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="priviousMonthButton"><i class="fas fa-arrow-circle-left"></i></button>
                </td>
                <td colspan=5></td>
                <td style="width: 10%;">
                    <input type="text" hidden id="nextMonthInput" value="'.now()->addMonth(1)->format("m-Y").'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="nextMonthButton"><i class="fas fa-arrow-circle-right"></i></button>
                </td>
            </tr>'.'<tr>
                <td style="width: 10%;">রবি</td>
                <td style="width: 10%;">সোম</td>
                <td style="width: 10%;">মঙ্গল</td>
                <td style="width: 10%;">বুধ</td>
                <td style="width: 10%;">বৃহস্পতি</td>
                <td style="width: 10%;">শুক্র</td>
                <td style="width: 10%;">শনি</td>
            </tr>
            <tr>';
        for($i = 1; $i <= $offset; $i++)
        {
            echo "<td></td>";
        }
        //  this will print the number of days.
        for($day = 1; $day <= $numberOfDays; $day++)
        {
            if( ($day + $offset - 1) % 7 == 0 && $day != 1)
            {
                echo "</tr> <tr>";
                $row_number++;
            }
            echo "<td>" . $daysBn[$day] . "</td>";
        }

        while( ($day + $offset) <= $row_number * 7)
        {
            echo "<td></td>";
            $day++;
        }
        echo "</tr></table>";

    }
@endphp


@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')
    <!-- Banner Area -->
    <section id="home_one_banner" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner_slider_wrapper owl-theme owl-carousel">
                        @foreach ($homeSliders as $perSlider)
                            <div class="banner_item">
                                <img src="{{ asset("images/home-slider/".$perSlider->image) }}" alt="{{ $perSlider->alt_text }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="banner_event_wrapper {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                        <div class="banner_event_item bg_green">
                            <div class="banner_event_heading ">
                                <h3>
                                    @if($currentLanguage == 'en')
                                        {{ __("Today's Events") }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("আজকের অনুষ্ঠান") }}
                                    @endif:
                                </h3>
                            </div>
                            <div class="banner_event_inner_wrapper">
                                @forelse ($todayEvents as $todayEvent)
                                    <div class="banner_event_inner_item">
                                        <h4>
                                            <i class="fas fa-circle"></i> {{ ($currentLanguage == "en") ? date("d-M-Y",strtotime($todayEvent->date_en) ) : $todayEvent->date_bn}}:
                                        </h4>
                                        <p>{{ ($currentLanguage == "en") ? $todayEvent->name_en : $todayEvent->name_bn}}</p>
                                    </div>
                                @empty
                                    <div class="banner_event_inner_item">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                {{ __("No events are available") }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="banner_event_wrapper {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                        <div class="banner_event_item bg_yellow">
                            <div class="banner_event_heading ">
                                <h3>
                                    @if($currentLanguage == 'en')
                                        {{ __("Past's Events") }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("অতীতের অনুষ্ঠানাদি") }}
                                    @endif:
                                </h3>
                            </div>
                            <div class="banner_event_inner_wrapper">
                                @forelse ($pastEvents as $pastEvent)
                                    <div class="banner_event_inner_item">
                                        <h4>
                                            <i class="fas fa-circle"></i> {{ ($currentLanguage == "en") ? date("d-M-Y",strtotime($pastEvent->date_en) ) : $pastEvent->date_bn}}:
                                        </h4>
                                        <p>{{ ($currentLanguage == "en") ? $pastEvent->name_en : $pastEvent->name_bn}}</p>
                                    </div>
                                @empty
                                    <div class="banner_event_inner_item">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                {{ __("No events are available") }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="banner_event_wrapper {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                        <div class="banner_event_item bg_past">
                            <div class="banner_event_heading">
                                <h3>
                                    @if($currentLanguage == 'en')
                                        {{ __("Upcoming's Events") }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("আসন্ন অনুষ্ঠানাদি") }}
                                    @endif:
                                </h3>
                            </div>
                            <div class="banner_event_inner_wrapper">
                                @forelse ($upcomingEvents as $upcomingEvent)
                                    <div class="banner_event_inner_item">
                                        <h4>
                                            <i class="fas fa-circle"></i> {{ ($currentLanguage == "en") ? date("d-M-Y",strtotime($upcomingEvent->date_en) ) : $upcomingEvent->date_bn}}:
                                        </h4>
                                        <p>{{ ($currentLanguage == "en") ? $upcomingEvent->name_en : $upcomingEvent->name_bn}}</p>
                                    </div>
                                @empty
                                    <div class="banner_event_inner_item">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                {{ __("No events are available") }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Area -->
    <section id="about_area_wrapper" class="section_padding bg_gray {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
        <div class="container">
            @foreach ($homePageSections as $homePageSection)
                @if ($homePageSection->type == "Text")
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="about_area_left_heading">
                                <div class="heading_left">
                                    <h2>{{ ($currentLanguage == "en") ? $homePageSection->name_en : $homePageSection->name_bn }}</h2>
                                </div>
                                <div class="about_content_left ">
                                    @if ($currentLanguage == "bn")
                                        {!! html_entity_decode($homePageSection->text_bn) !!}
                                    @endif

                                    @if ($currentLanguage == "en")
                                        {!! html_entity_decode($homePageSection->text_en) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about_img_right">
                                <img src="{{ asset("images/dynamicpage/".$homePageSection->image) }}" alt="img">
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Calendar Area -->
    <section id="calendar_area_wrapper" class="section_padding {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="app">
                        <div class="app__main">
                            <div class="calendar">

                                {{-- @if($currentLanguage == 'en')
                                    <div id="calendar"></div>
                                @endif --}}

                                {{-- @if($currentLanguage == 'bn')
                                    <script src="{{ asset("js/bncalendar.js") }}"></script>
                                    <script type="text/javascript">

                                        var todaydate=new Date();
                                        todaydate.setTime(todaydate.getTime() +(todaydate.getTimezoneOffset()+360)*60*1000);
                                        var curmonth=todaydate.getMonth()+1; //get current month (1-12)
                                        var curyear=todaydate.getFullYear(); //get current year

                                        document.write(buildCal(curmonth ,curyear, "main", "month", "daysofweek", "days", 1));
                                    </script>
                                @endif --}}

                                <div id="calenderView">
                                    <div class="d-flex justify-content-center mb-2">
                                        <span id="banglaYearMonthSpan">{{ now() }} </span>
                                    </div>

                                    <div class="table-responsive">

                                        @php
                                            showCurrentMonthCalenderViewHome(now()->format("m"),now()->format("Y"));
                                        @endphp
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="app__main">
                            <div class="calendar">
                                <div id="calendar1"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="banner_event_wrapper">
                        <div class="banner_event_item bg_yellow">
                            <div class="banner_event_heading">
                                <h3>
                                    @if($currentLanguage == 'en')
                                        {{ __("Past's Events") }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("অতীতের অনুষ্ঠানাদি") }}
                                    @endif:
                                </h3>
                            </div>
                            <div class="banner_event_inner_wrapper">
                                @forelse ($pastEvents as $pastEvent)
                                    <div class="banner_event_inner_item">
                                        <h4>
                                            <i class="fas fa-circle"></i> {{ ($currentLanguage == "en") ? date("d-M-Y",strtotime($pastEvent->date_en) ) : $pastEvent->date_bn}}:
                                        </h4>
                                        <p>{{ ($currentLanguage == "en") ? $pastEvent->name_en : $pastEvent->name_bn}}</p>
                                    </div>
                                @empty
                                    <div class="banner_event_inner_item">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                {{ __("No events are available") }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="banner_event_item bg_past">
                            <div class="banner_event_heading">
                                <h3>
                                    @if($currentLanguage == 'en')
                                        {{ __("Upcoming's Events") }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("আসন্ন অনুষ্ঠানাদি") }}
                                    @endif:
                                </h3>
                            </div>
                            <div class="banner_event_inner_wrapper">
                                @forelse ($upcomingEvents as $upcomingEvent)
                                    <div class="banner_event_inner_item">
                                        <h4>
                                            <i class="fas fa-circle"></i> {{ ($currentLanguage == "en") ? date("d-M-Y",strtotime($upcomingEvent->date_en) ) : $upcomingEvent->date_bn}}:
                                        </h4>
                                        <p>{{ ($currentLanguage == "en") ? $upcomingEvent->name_en : $upcomingEvent->name_bn}}</p>
                                    </div>
                                @empty
                                    <div class="banner_event_inner_item">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                {{ __("No events are available") }}
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                {{ __("কোন অনুষ্ঠানাদি উপলব্ধ নেই") }}
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Gallery  -->
    <section id="photo_gallery_area" class="section_padding_bottom {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
        <div class="container">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="common_heading_center">
                        <h2>
                            @if($currentLanguage == 'en')
                                {{ __('Photo gallery') }}
                            @endif

                            @if($currentLanguage == 'bn')
                                {{ __("ফটো গ্যালারি") }}
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="photo_gallery_slider owl-theme owl-carousel">
                        @foreach ($galleryImageItems as $galleryItem)
                            <div class="photo_gallery_item">
                                <img src="{{ asset("images/gallery/".$galleryItem->image) }}" alt="{{ $galleryItem->alt_text }}" style="width:375px;height:340px;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push("onPageExtraJS")
    <script>
        $(document).ready(function(){
            $('#banglaYearMonthSpan').bongabdo({
                format: "MM - YY"
            });

            $( "#calenderView " ).on( "click", "#nextMonthButton" ,function() {
                var nextMonth = $("#nextMonthInput").val();
                const pMArray = nextMonth.split("-");

                $.ajax({
                    url: "{{ route('calender.generate') }}",
                    type: 'GET',
                    dataType: 'json',
                    data:{'month':pMArray[0],'year':pMArray[1]},
                    success: function(responce) {
                        console.log(responce);
                        $('#calenderView').html(responce);
                    }
                });
            });

            $( "#calenderView" ).on( "click", "#priviousMonthButton", function() {
                var priviousMonth = $("#priviousMonthInput").val();
                const pMArray = priviousMonth.split("-");

                $.ajax({
                    url: "{{ route('calender.generate') }}",
                    type: 'GET',
                    dataType: 'json',
                    data:{'month':pMArray[0],'year':pMArray[1]},
                    success: function(responce) {
                        console.log(responce);
                        $('#calenderView').html(responce);
                    }
                });
            });

        });
    </script>
@endpush
