
@php
    $currentLanguage = (session()->get('locale') == null) ?  "en" : session()->get('locale');
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

        <link href="{{ asset("css/nice-admin.css") }}" rel="stylesheet">
        <link href="{{ asset("icons/bootstrap-icons.css") }}" rel="stylesheet">


        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        @stack('onPageExtraCss')

    </head>
    <body>

        <div id="app">
            <header id="header" class="header fixed-top d-flex align-items-center">
                <!-- Logo begin -->
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route("dashboard.index") }}" class="logo d-flex align-items-center">
                            <span class="d-none d-lg-block"> {{ $setting["App"]["site_name_en"] }}</span>
                        </a>
                        <i class="bi bi-list toggle-sidebar-btn"></i>
                    </div>
                <!-- Logo begin -->

                <!-- Nav bar begin -->
                    <nav class="header-nav ms-auto">
                        <ul class="d-flex align-items-center">

                            <!-- User begin -->
                                @auth
                                    <li class="nav-item dropdown pe-3">
                                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                            <i class="bi bi-person-fill"></i>
                                            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                            <li class="dropdown-header">
                                                <h6>{{ Auth::user()->name; }}</h6>
                                                <span>
                                                    {{ __('Roles') }} {{ __(':') }} {{ Auth::user()->user_role }}
                                                </span>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            <li>
                                                <a href="#" type="button" class="dropdown-item d-flex align-items-center text-dark" data-bs-toggle="modal" data-bs-target="#logOutConfirmationModel">
                                                    <i class="bi bi-box-arrow-right me-2"></i>
                                                    <span>Sign Out</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                @endauth
                            <!-- User end -->
                        </ul>
                    </nav>
                <!-- Nav bar end -->
            </header>

            <!-- Side bar begin -->
            <aside id="sidebar" class="sidebar">
                <ul class="sidebar-nav" id="sidebarNav">

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("dashboard.index") }}">
                            <i class="bi bi-grid"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("country.area.index") }}">
                            <i class="bi bi-wallet"></i>
                            <span>Divisional area</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("home.slider.index") }}">
                            <i class="bi bi-sliders"></i>
                            <span>Home slider</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("gallery.index") }}">
                            <i class="bi bi-display"></i>
                            <span>Gallary</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("event.index") }}">
                            <i class="bi bi-calendar-date"></i>
                            <span>Event</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("donate.account.index") }}">
                            <i class="bi bi-wallet"></i>
                            <span>Donate account</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("council.member.index") }}">
                            <i class="bi bi-people"></i>
                            <span>Council member</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("staff.member.index") }}">
                            <i class="bi bi-people"></i>
                            <span>Staff member</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("mondir.and.ashram.index") }}">
                            <i class="bi bi-building"></i>
                            <span>Mondir and ashram</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("dynamic.page.index") }}">
                            <i class="bi bi-file"></i>
                            <span>Pages</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("site.menu.index") }}">
                            <i class="bi bi-menu-app"></i>
                            <span>Site menu</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route("account.profile.index") }}">
                            <i class="bi bi-person"></i>
                            <span>Account profile</span>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- Side bar end-->

            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>@hasSection('pageTitle') @yield("pageTitle") @endif</h1>

                    @hasSection('navBreadCrumb')
                        @yield("navBreadCrumb")
                    @endif

                </div>

                <section class="section">
                    @hasSection('statusMessage') @yield("statusMessage") @endif

                    @hasSection('content')
                        @yield("content")
                    @endif
                </section>
            </main>

            <footer id="footer" class="footer">
                <div class="copyright">
                    &copy; {{ __('Copyright') }} <strong><span>{{ $setting["App"]["site_name_en"]; }}</span></strong> {{ date("Y") }}. {{ __('All Rights Reserved') }}
                </div>
                <div class="credits">
                    {{ __('Develop by') }} <a href="#">{{ __('AndIt.co') }}</a>
                </div>
            </footer>

            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

            <div class="modal fade" id="logOutConfirmationModel" tabindex="-1" aria-labelledby="logOutConfirmationModelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="logOutConfirmationModelLabel">Log out confirmation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure that you want to log out?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="document.getElementById('authUserLogOutForm').submit();">Yes</button>
                            <form id="authUserLogOutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Scripts -->
        <script src="{{ asset("js/jquery-3.6.4.min.js") }}" ></script>
        <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>

        <script src="{{ asset("js/nice-admin.js") }}"></script>
        @stack('onPageExtraJS')

    </body>
</html>
