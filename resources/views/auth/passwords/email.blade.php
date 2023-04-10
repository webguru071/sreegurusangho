@php
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
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Reset </title>

        <link rel="icon" href="{{  asset($siteFaviconPublicUrl.$siteFavicon) }}">

        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
        <link href="{{ asset("icons/bootstrap-icons.css") }}" rel="stylesheet">
        <link href="{{ asset("css/nice-admin.css") }}" rel="stylesheet">
    </head>

    <body>
        <main>
            <div class="container">

                <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                <div class="d-flex justify-content-center py-4">
                                    <a href="{{env('APP_URL')."/page"."/"."home" }}" class="logo d-flex align-items-center w-auto">
                                        {{-- <img src="assets/img/logo.png" alt=""> --}}
                                        <span class="d-none d-lg-block">Sri Guru Sangha</span>
                                    </a>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body mb-1">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-body">

                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Reset to Your Account</h5>
                                            <p class="text-center small">Enter your email to reset</p>
                                        </div>

                                        <form class="row g-3" action="{{ route('password.email') }}" method="post">
                                            @csrf
                                            <div class="col-12">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="submit">Send Password Reset Link</button>
                                            </div>

                                            <div class="col-12">

                                                @if (Route::has('login'))
                                                    <p class="small mb-0">
                                                        <a class="btn btn-link" href="{{ route('login') }}">
                                                            {{ __('Already have a account') }}
                                                        </a>
                                                    </p>
                                                @endif
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <div class="credits">
                                    {{ __('Develop by') }} <a href="#">{{ __('AndIt.co') }}</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script src="{{ asset("js/jquery-3.6.4.min.js") }}" ></script>
        <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>
        <script src="{{ asset("js/nice-admin.js") }}"></script>
    </body>
</html>
