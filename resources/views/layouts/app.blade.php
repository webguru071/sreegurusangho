
@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');

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

    $siteLogo = $setting["App"]["logo"];
    $siteLogoPublicUrl = "images/setting/app/";

    $siteManubarLogo = $setting["App"]["manubar_logo"];
    $siteManubarLogoPublicUrl = "images/setting/app/";

    $siteFavicon =  $setting["App"]["favicon"];
    $siteFaviconPublicUrl = "images/setting/app/";

    if((($setting["App"]["logo"] == "default-logo.png") || ($setting["App"]["logo"] == null)) && !(file_exists(asset($siteLogoPublicUrl. $setting["App"]["logo"] ) ) ) ){
        $siteLogo = "default-logo.png";
    }

    if((($setting["App"]["manubar_logo"] == "default-manubar-logo.png") || ($setting["App"]["manubar_logo"] == null)) && !(file_exists(asset($siteLogoPublicUrl. $setting["App"]["manubar_logo"] ) ) ) ){
            $siteManubarLogo = "default-manubar-logo.png";
    }

    if((($setting["App"]["favicon"] == "default-favicon.png") || ($setting["App"]["favicon"] == null)) && !(file_exists(asset($siteFaviconPublicUrl. $setting["App"]["favicon"] ) ) ) ){
            $siteFavicon ="default-favicon.png";
    }

    $topBarTitle = $setting["App"]["topbar_title_en"];
    $topBarfounder = $setting["App"]["topbar_founder_en"];
    $topBarFooter= $setting["App"]["footer_en"];

    $footerFbLink = $setting["App"]["footer_fb_link"];
    $footerYoutubLink = $setting["App"]["footer_youtube_link"];
    $footerTwitterLink = $setting["App"]["footer_twitter_link"];
    $footerLinkedinLink = $setting["App"]["footer_linkedin_link"];

    $donateAccounts = $setting["App"]["donate_accounts"];

    if($currentLanguage == 'bn'){
        $topBarTitle = $setting["App"]["topbar_title_bn"];
        $topBarfounder = $setting["App"]["topbar_founder_bn"];
        $topBarFooter = $setting["App"]["footer_bn"];
    }

    function showCurrentMonthCalenderViewLayout($current_Month, $year){
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

                    <input type="text" hidden id="layoutPriviousMonthInput" value="'.now()->subMonth(1)->format("m-Y").'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="layoutPriviousMonthButton"><i class="fas fa-arrow-circle-left"></i></button>
                </td>
                <td colspan=5></td>
                <td style="width: 10%;">
                    <input type="text" hidden id="layoutNextMonthInput" value="'.now()->addMonth(1)->format("m-Y").'" readonly>
                    <button type="button" class="btn btn-default btn_theme" id="layoutNextMonthButton"><i class="fas fa-arrow-circle-right"></i></button>
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

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield("pageTitle")</title>

        <link rel="icon" href="{{  asset($siteFaviconPublicUrl.$siteFavicon) }}">

        <!-- Css -->
        <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/animate.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/fontawesome.all.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/owl.carousel.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/magnific-popup.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/owl.theme.default.min.css") }}" rel="stylesheet">
        <link href="{{ asset("css/navber.css") }}" rel="stylesheet">
        <link href="{{ asset("css/meanmenu.css") }}" rel="stylesheet">
        <link href="{{ asset("css/style.css") }}" rel="stylesheet">
        <link href="{{ asset("css/style-2.css") }}" rel="stylesheet">
        <link href="{{ asset("css/responsive.css") }}" rel="stylesheet">
        <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
        @stack('onPageExtraCss')
        <style type="text/css">

            .main {
                width:100%;
                border:1px solid black;
            }

            .month {
                background-color:black;
                font:bold 24px verdana;
                color:white;
            }

            .daysofweek {
                background-color:gray;
                font:bold 24px verdana;
                color:white;
            }

            .days {
                font-size: 24px;
                font-family:verdana;
                color:black;
                background-color: lightyellow;
                padding: 2px;
            }

            .days #bangla{
                font-size: 20px;
                text-align:left;
                font-family:verdana;
                color: green;
            }

            .days #today{
                font-weight: bold;
                color: red;
            }

        </style>
    </head>
    <body>
        <!-- preloader Area -->
        <div class="preloader">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="lds-spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="app">
            <header class="main_header_arae">
                <!-- Top Bar -->
                <div class="topbar-area">
                    <div class="container-fluid">
                        <div class="row align-items-center" style="z-index: 999; position: relative;">
                            <div class="col-lg-2">
                                <div class="logo_topbar">
                                    <a href="{{env('APP_URL')."/page"."/"."home" }}">
                                        <img src="{{ asset($siteLogoPublicUrl.$siteLogo) }}" alt="logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="topbar_slugen_wrapper {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                    <img src="{{ asset($siteLogoPublicUrl.$siteLogo) }}" alt="">
                                    <p>{{  $topBarTitle }}</p>
                                    <p class="topbar_text_md ">
                                        @if($currentLanguage == 'en')
                                            {{ __('Founder of Sri Guru Sangha') }}
                                        @endif

                                        @if($currentLanguage == 'bn')
                                            {{ __("শ্রীগুরু সঙ্ঘের প্রতিষ্ঠাতা") }}
                                        @endif
                                    </p>
                                    <p class="topbar_text_lg">{{  $topBarfounder }}</p>
                                    <div class="reg_num_phone">
                                        <p>
                                            @if($currentLanguage == 'en')
                                                Reg No: 11018/PIRO/KAW/24
                                            @endif

                                            @if($currentLanguage == 'bn')
                                                রেজি নং: ১১০১৮/PIRO/KAW/২৪
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="logo_topbar nabar_left_sider">
                                    <a href="{{env('APP_URL')."/page"."/"."home" }}">
                                        <img src="{{ asset($siteLogoPublicUrl.$siteLogo) }}" alt="logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navbar Bar -->
                <div class="navbar-area">
                    <div class="main-responsive-nav">
                        <div class="container">
                            <div class="main-responsive-menu">
                                <div class="logo">
                                    <a href="{{ env('APP_URL')."/page"."/"."home" }}">
                                        <img src="{{ asset($siteManubarLogoPublicUrl.$siteManubarLogo) }}" alt="logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-navbar">
                        <div class="container-fluid">
                            <nav class="navbar navbar-expand-md navbar-light">
                                <a class="navbar-brand" href="{{ env('APP_URL')."/page"."/"."home" }}">
                                    <img src="{{ asset($siteManubarLogoPublicUrl.$siteManubarLogo) }}" alt="logo">
                                </a>
                                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                    <ul class="navbar-nav">
                                        @foreach ($siteMenus as $perMenu)
                                            @if ($perMenu->siteMenus->count() == 0)
                                                <li class="nav-item {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                                    <a href="{{ env('APP_URL')."/page"."/".$perMenu->dynamicPage->slug }}" class="nav-link {{ ( ( Request::is($perMenu->dynamicPage->slug) ) || ( Request::is($perMenu->dynamicPage->slug.'/*') ) ) ? "active" : "" }}">
                                                        @if($currentLanguage == 'en')
                                                            {{ $perMenu->name_en }}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {{ $perMenu->name_bn }}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endif

                                            @if ($perMenu->siteMenus->count() > 0)
                                                <li class="nav-item {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                                    <a href="" class="nav-link">
                                                        @if($currentLanguage == 'en')
                                                            {{ $perMenu->name_en }}
                                                        @endif

                                                        @if($currentLanguage == 'bn')
                                                            {{ $perMenu->name_bn }}
                                                        @endif
                                                        <i class="fas fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                                        @foreach ($perMenu->siteMenus as $perSubMenu)
                                                            <li class="nav-item">
                                                                <a href="{{ env('APP_URL')."/page"."/".$perSubMenu->dynamicPage->slug }}" class="nav-link {{ ( ( Request::is($perSubMenu->dynamicPage->slug) ) || ( Request::is($perSubMenu->dynamicPage->slug.'/*') ) ) ? "active" : "" }}">
                                                                    @if($currentLanguage == 'en')
                                                                        {{ $perSubMenu->name_en }}
                                                                    @endif

                                                                    @if($currentLanguage == 'bn')
                                                                        {{ $perSubMenu->name_bn }}
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <div class="others-options d-flex align-items-center {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                        <div class="option-item">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#calendar_modal" class="btn btn_md btn_custom">
                                                <i class="fas fa-calendar-alt"></i>
                                                @if($currentLanguage == 'en')
                                                    {{ __('Calendar') }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("দিনপঞ্জিকা") }}
                                                @endif
                                            </button>
                                        </div>
                                        <div class="option-item">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#donate_modal" class="btn btn_md btn_theme">
                                                <i class="fas fa-hand-holding-usd"></i>
                                                @if($currentLanguage == 'en')
                                                    {{ __('Donate now') }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("দক্ষিণা") }}
                                                @endif
                                            </button>
                                        </div>
                                        <div class="lan_change {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                            <select class="change-language">
                                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>বাংলা</option>
                                            </select>
                                        </div>
                                        <div class="reg_num_pose">
                                            <p>
                                                @if($currentLanguage == 'en')
                                                    Reg No: 11018/PIRO/KAW/24
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    রেজি নং: ১১০১৮/PIRO/KAW/২৪
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a class="navbar-brand display_nones" href="{{ env('APP_URL')."/page"."/"."home" }}">
                                        <img src="{{ asset($siteManubarLogoPublicUrl.$siteManubarLogo) }}" alt="logo">
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <div class="others-option-for-responsive">
                        <div class="container">
                            <div class="dot-menu">
                                <div class="inner">
                                    <div class="circle circle-one"></div>
                                    <div class="circle circle-two"></div>
                                    <div class="circle circle-three"></div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="option-inner">
                                    <div class="others-options d-flex align-items-center">
                                        <div class="option-item">
                                            <button  type="button" data-bs-toggle="modal" data-bs-target="#calendar_modal"
                                                class="btn btn_md btn_custom"><i class="fas fa-calendar-alt"></i>
                                                @if($currentLanguage == 'en')
                                                    {{ __('Calendar') }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("দিনপঞ্জিকা") }}
                                                @endif
                                            </button>
                                        </div>
                                        <div class="option-item">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#donate_modal"
                                                class="btn btn_md btn_theme"><i class="fas fa-hand-holding-usd"></i>
                                                @if($currentLanguage == 'en')
                                                    {{ __('Donate now') }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("দক্ষিণা") }}
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                    <div class="lan_change {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                        <select class="change-language">
                                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                                            <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>বাংলা</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div>
                @yield('content')
            </div>

            <!-- Footer  -->
            <footer id="footer_area_main">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="footer_text_left {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                <p>
                                    {{ $topBarFooter }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="footer_text_right {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                <p>
                                    @if($currentLanguage == 'en')
                                        {{ __('Connect with us') }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ __("আমাদের সাথে যোগাযোগ করুন") }}
                                    @endif
                                    :
                                </p>
                                <div class="footer_social_icon">
                                    <ul>

                                        @if(!($footerFbLink == null))
                                            <li><a href="{{ $footerFbLink }}" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                        @endif

                                        @if(!($footerTwitterLink == null))
                                            <li><a href="{{ $footerTwitterLink }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        @endif

                                        @if(!($footerYoutubLink == null))
                                            <li><a href="{{ $footerYoutubLink }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                        @endif

                                        @if(!($footerLinkedinLink == null))
                                            <li><a href="{{ $footerLinkedinLink }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- Modal Area Donate-->
            <div class="modal fade" id="donate_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal_donate_wrapper  {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }} ">

                                @forelse ($donateAccounts as $donateAccount)
                                    <div class="modal_donate_item">
                                        <img src="{{ asset("images/donate-account/".$donateAccount->image) }}" alt="icon">
                                        <div class="modal_donate_flex">
                                            @if ($currentLanguage == "bn")
                                                {!! html_entity_decode($donateAccount->account_bn) !!}
                                            @endif

                                            @if ($currentLanguage == "en")
                                                {!! html_entity_decode($donateAccount->account_en) !!}
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="modal_donate_item">
                                        <div class="modal_donate_flex {{ ($currentLanguage == 'bn') ? 'bn-font' :  null  }}">
                                            <p>
                                                @if($currentLanguage == 'en')
                                                    {{ __('No record found') }}
                                                @endif

                                                @if($currentLanguage == 'bn')
                                                    {{ __("কোন তথ্য পাওয়া যায়নি.") }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Area Calendar-->
            <div class="modal fade" id="calendar_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="app">
                                <div class="app__main">
                                    <div class="calendar">

                                        {{-- @if($currentLanguage == 'en')
                                            <div id="calendar1"></div>
                                        @endif

                                        @if($currentLanguage == 'bn')
                                            <script src="{{ asset("js/bncalendar.js") }}"></script>
                                            <script type="text/javascript">

                                                var todaydate=new Date();
                                                todaydate.setTime(todaydate.getTime() +(todaydate.getTimezoneOffset()+360)*60*1000);
                                                var curmonth=todaydate.getMonth()+1; //get current month (1-12)
                                                var curyear=todaydate.getFullYear(); //get current year

                                                document.write(buildCal(curmonth ,curyear, "main", "month", "daysofweek", "days", 1));
                                            </script>
                                        @endif --}}

                                        {{-- <div class="">
                                            <h4 class="h5p calendar-text">
                                                &#9884;
                                                                                                     দিনপঞ্জিকা
                                                &#9884;
                                            </h4>
                                            <div id="content">
                                                <div style="clear: both;"></div>
                                                <div class="pgfgl">
                                                    <div>
                                                        <div class="table-responsive">
                                                            <div id="Calendar">
                                                                <table width="100%" style="background-color: #5daee2;    border-top-left-radius: 5px;border-top-right-radius: 5px;">
                                                                  <tr>
                                                                      <td class="mNav"><a onclick="LoadMonth('03', '2023')"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a></td>
                                                                      <td colspan="5" class="cMonth">
                                                                                                                                                                              চৈত্র - ১৪২৯ ||

                                                                                                                                                                                   এপ্রিল - ২০২৩
                                                                      </td>
                                                                      <td class="mNav"><a onclick="LoadMonth('05', '2023')"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td class="wDays">সোম</td>
                                                                      <td class="wDays">মঙ্গল</td>
                                                                      <td class="wDays">বুধ</td>
                                                                      <td class="wDays">বৃহঃ</td>
                                                                      <td class="wDays">শুক্র</td>
                                                                      <td class="wDays">শনি</td>
                                                                      <td class="wDays">রবি</td>
                                                                  </tr>
                                                                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০১</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০২</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td></tr><tr><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৩</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৪</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৫</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৬</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৭</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৮</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>০৯</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td></tr><tr><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১০</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১১</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১২</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৩</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৪</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৫</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৬</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td></tr><tr><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৭</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৮</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>১৯</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২০</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২১</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২২</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৩</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td></tr><tr><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৪</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৫</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৬</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৭</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৮</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>২৯</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td><td class='noevent'><div class='popup' onclick="myFunction()"><table class='tabl_intb'><tr><td><hr></td><td rowspan='2'>৩০</td></tr><tr><td></td></tr></table> <span class='popuptext' id='myPopup'> <hr>  <hr> <hr> -  মিঃ</span></div></td></tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <h4 style="width: 100%; margin: 0px auto; padding: 10px 6px; background: #f3d25d; text-align: center; font-size: 16px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;color: #000;">
                                                            বিস্তারিত দেখার জন্য তারিখের উপর ক্লিক করুন ...
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div id="layoutCalenderView">
                                            <div class="d-flex justify-content-center mb-2">
                                                <span>{{ now()->format("M-Y") }} / </span> <span id="layoutBanglaYearMonthSpan">{{ now() }} </span>
                                            </div>

                                            <div class="table-responsive">

                                                @php
                                                    showCurrentMonthCalenderViewLayout(now()->format("m"),now()->format("Y"));
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Scripts -->
        <script src="{{ asset("js/jquery-3.6.4.min.js") }}" ></script>
        <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>

        <script src="{{ asset("js/jquery.meanmenu.js") }}"></script>
        <script src="{{ asset("js/owl.carousel.min.js") }}"></script>
        <script src="{{ asset("js/jquery.magnific-popup.min.js") }}"></script>
        <script src="{{ asset("js/wow.min.js") }}"></script>
        <script src="{{ asset("js/custom.js") }}"></script>
        <script src="{{ asset("js/date.js") }}"></script>
        <script src="{{ asset("js/jquery.bongabdo.min.js") }}"></script>

        @stack('onPageExtraJS')

        <script>
            $( document ).ready(function() {
                var url = "{{ route('language.change') }}";
                $(".change-language").change(function(){
                    window.location.href = url + "?lang="+ $(this).val();
                });

                $('#layoutBanglaYearMonthSpan').bongabdo({
                    format: "MM - YY"
                });

                $( "#layoutCalenderView " ).on( "click", "#layoutNextMonthButton" ,function() {
                var nextMonth = $("#layoutNextMonthInput").val();
                const pMArray = nextMonth.split("-");

                $.ajax({
                    url: "{{ route('layout.calender.generate') }}",
                    type: 'GET',
                    dataType: 'json',
                    data:{'month':pMArray[0],'year':pMArray[1]},
                    success: function(responce) {
                        console.log(responce);
                        $('#layoutCalenderView').html(responce);
                    }
                });
            });

            $( "#layoutCalenderView" ).on( "click", "#layoutPriviousMonthButton", function() {
                var priviousMonth = $("#layoutPriviousMonthInput").val();
                const pMArray = priviousMonth.split("-");

                $.ajax({
                    url: "{{ route('layout.calender.generate') }}",
                    type: 'GET',
                    dataType: 'json',
                    data:{'month':pMArray[0],'year':pMArray[1]},
                    success: function(responce) {
                        console.log(responce);
                        $('#layoutCalenderView').html(responce);
                    }
                });
            });
            });
        </script>
    </body>
</html>
