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
            <input type="number" min="0" id="gallerySkip" class="form-control" value="{{ $gallerySkipVG }}" readonly hidden>
            <div class="row mb-2" id="imageGallery">
                @foreach ($galleryItemsVG as $perItem)
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                        <article class="">
	                        <figure>
	                    	    <iframe width="100%" height="230" src="{{ $perItem->video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
	                        </figure>
	                        <div class="article-title">
	                    	    @if($currentLanguage == 'en')
                                    {{ $perItem->title_en }}
                                @endif

                                @if($currentLanguage == 'bn')
                                    {{ $perItem->title_bn }}
                                @endif
	                        </div>
	                    </article>
                    </div>
                @endforeach

            </div>

            @if($enablePaginationVG == 1)
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
                        url: '{{ route("video.gallery.page") }}',
                        data:{"gallery_skip":gallerySkip},
                    })
                    .done(function (response) {
                        gallerySkip = gallerySkip + parseInt(response["galleries"].length);
                        $('#gallerySkip').val( gallerySkip);

                        if( parseInt(response["gallery_total"]) > 0 ){
                            $("#paginationDiv").show()
                        }

                        $.each(response["galleries"], function( index, value ) {
                            var gHtml = '';
                            gHtml = gHtml + '<div class="col-lg-3 col-md-6 col-sm-12 col-12">';
                                gHtml = gHtml + '<article class="">';
                                    gHtml = gHtml + '<figure class="">';
                                        gHtml = gHtml + '<iframe width="100%" height="230" src="'+value["video_url"]+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>';
                                    gHtml = gHtml + '</figure>';
                                    gHtml = gHtml + '<div class="article-title">';
                                        gHtml = gHtml + "<p>@if($currentLanguage == 'en')"+value["title_en"]+"@endif @if($currentLanguage == 'bn')"+value["title_bn"]+"@endif</p>";
                                    gHtml = gHtml + '</div>';
                                gHtml = gHtml + '</article>';
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
        });
    </script>
@endpush
