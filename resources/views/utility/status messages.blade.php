@auth

    @if(Session::has('errors'))
        <div class="alert-messages alert alert-danger d-block" role="alert">
            <div class="row">
                <div class="col-11 col-lg-11 col-md-11 col-sm-11">
                    @if (!(is_string($errors)))
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{  $message }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if (is_string($errors))
                        <b>
                            {{ $errors }}
                        </b>
                    @endif
                </div>
                <div class="p-1 col-1 col-lg-1 col-md-1 col-sm-1">
                    <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endauth

@if(Session::has('status'))
    <div class="alert-messages alert alert-success d-block" role="alert">
        <div class="row">
            <div class="col-11 col-lg-11 col-md-11 col-sm-11">
                <p class="text-center">
                    <b>{{ Session::get('status') }}</b>
                </p>
            </div>
            <div class="col-1 col-lg-1 col-md-1 col-sm-1">
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert-messages alert alert-warning d-block" role="alert">
        <div class="row">
            <div class="col-11 col-lg-11 col-md-11 col-sm-11">
                <p class="text-center">
                    <b>{{ Session::get('warning') }}</b>
                </p>
            </div>
            <div class="col-1 col-lg-1 col-md-1 col-sm-1">
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if (Session::has('resent'))
    <div class="alert-messages alert alert-success d-block" role="alert">
        <div class="row">
            <div class="col-11 col-lg-11 col-md-11 col-sm-11">
                <b>A fresh verification link has been sent to your email address</b>
            </div>
            <div class="col-1 col-lg-1 col-md-1 col-sm-1">
                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@push('onPageExtraJS')
    <script>
        $(document).ready(function(){
            if ($('.alert-messages').length){
                setTimeout(function(){
                    $('.alert-messages').remove();
                }, 15000);
            }
        });
    </script>
@endpush
