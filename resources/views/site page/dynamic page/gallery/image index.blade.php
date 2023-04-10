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
            <input type="number" min="0" id="gallerySkip" class="form-control" value="{{ $gallerySkipIG }}" readonly hidden>
            <div class="row popup-gallery" id="imageGallery">
                @foreach ($galleryItemsIG as $perItem)
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="photo_gallery_wrapper">
                            <div class="photo_gallery_img">
                                <a href="{{ asset("images/gallery/".$perItem->image) }}">
                                    <img src="{{ asset("images/gallery/".$perItem->image) }}" alt="img">
                                </a>
                            </div>
                            <div class="photo_gallery_text">
                                <p>
                                    @if($currentLanguage == 'en')
                                        {{ $perItem->title_en }}
                                    @endif

                                    @if($currentLanguage == 'bn')
                                        {{ $perItem->title_bn }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($enablePaginationIG == 1)
                <div class="row" id="paginationDiv">
                    <div class="col-lg-12">

                        <div class="load_more_btn">
                            <button type="button"  class="btn btn_md btn_theme" id="loadMoreButton">Load more...</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push("onPageExtraJS")
    <script>
        $(document).ready(function(){
            $("#loadMoreButton").click(function(){
                    let gallerySkip = $('#gallerySkip').val();
                    gallerySkip = parseInt(gallerySkip);

                    $.ajax({
                        url: '{{ route("image.gallery.page") }}',
                        data:{"gallery_skip":gallerySkip},
                    })
                    .done(function (response) {
                        gallerySkip = gallerySkip + parseInt(response["galleries"].length);
                        $('#gallerySkip').val( gallerySkip);

                        if( parseInt(response["gallery_total"]) > 0 ){
                            $("#paginationDiv").show()
                        }

                        $.each(response["galleries"], function( index, value ) {
                            var galImageURL ='{{ asset("images/gallery") }}';
                            galImageURL =  galImageURL+"/" + value["image"];

                            var cloneGalleryDiv = $("#imageGallery").clone();

                            var gHtml = '';
                            gHtml = gHtml + '<div class="col-lg-3 col-md-6 col-sm-12 col-12">';
                                gHtml = gHtml + '<div class="photo_gallery_wrapper">';
                                    gHtml = gHtml + '<div class="photo_gallery_img">';
                                        gHtml = gHtml + '<a href="'+galImageURL+'">';
                                            gHtml = gHtml + '<img src="'+galImageURL+'" alt="img" style="width:375px; height:340px;">';
                                        gHtml = gHtml + '</a>';
                                    gHtml = gHtml + '</div>';

                                    gHtml = gHtml + '<div class="photo_gallery_text">';
                                        gHtml = gHtml + "<p>@if($currentLanguage == 'en')"+value["title_en"]+"@endif @if($currentLanguage == 'bn')"+value["title_bn"]+"@endif</p>";
                                    gHtml = gHtml + '</div>';

                                gHtml = gHtml + '</div>';
                            gHtml = gHtml + '</div>';

                            $('#imageGallery').append(gHtml);

                        });

                        if( ( parseInt(response["gallery_total"])  == gallerySkip) || ( gallerySkip > parseInt(response["gallery_total"]) ) ){
                            $("#paginationDiv").hide()
                        }
                    })
                    .fail(function (response) {
                        console.log(response);
                    });

            });

            $(document).ready(function () {
                $('.popup-gallery').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    }
                });
            });

        });
    </script>
@endpush
