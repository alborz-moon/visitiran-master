@extends('layouts.structure')
@section('seo')
    <title>{{ $blog['header'] }}</title>
    <meta property="og:title" content="{{ $blog['header'] }}" />
    <meta name="twitter:title" content="{{ $blog['header'] }}" />
    <meta property="og:site_name" content="{{ $blog['header'] }}" />

    
    <meta property="og:image" content="{{ $blog['img'] }}"/>
    <meta property="og:image:secure_url" content="{{ $blog['img'] }}"/>
    <meta name="twitter:image" content="{{ $blog['img'] }}"/>
    <meta property="og:description" content="{{ $blog['digest'] }}" />
    <meta name="twitter:description" content="{{ $blog['digest'] }}" />
    <meta name="description" content="{{ $blog['digest'] }}"/>

    <meta name="keywords" content="{{ $blog['keywords'] }}" />
    <meta property="article:tag" content="{{ $blog['article_tags'] }}"/>

@stop
@section('content')
            <main class="page-content TopParentBannerMoveOnTop">
            <div class="container">
                {{-- <h2 class="mt-4 mb-2">اخبار</h2> --}}
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-md-8 col-sm-12 mb-4">
                            <div>
                                <img class="w-100 h-100" src="{{ $blog['img'] }}" alt="{{ $blog['alt'] }}">
                            </div>
                            <div class="d-flex spaceBetween overFlowHidden mx-3 mt-3">
                                <p>{{ $blog['created_at'] }}</p>
                                <p class="border px-4 py-1 borderRadius15">{{ $blog['tags'] }}</p>
                            </div>
                            <hr>
                            <h1 class="mt-3 mb-4">{{ $blog['header'] }}</h1>
                            <p>{!! $blog['description'] !!}</p>
                        </div>
                        <div class="col-lg-3 col-md-4 d-none d-md-block">
                            <div style="position: sticky;top:150px">
                                <div class="title mb-3">تازه ترین ها</div>
                                <hr>
                                    <div id="shimmer-blog" style="display: flex; flex-wrap: wrap; gap: 0px;">
                                        @for($i = 0; $i < 5; $i++)                                                
                                            <div class="container p-0 m-0 py-3 SimmerParent">
                                                <div class="row p-0 m-0">
                                                <div class="col-4 p-0 m-0">
                                                <div class="shimmerBG pt-1 blogImgSize"></div>
                                                </div>
                                                <div class="col-8 p-0 m-0">
                                                <div style="height: 60px" class="d-flex justify-content-start align-items-center" >
                                                <div class="shimmerBG content-line"></div>
                                                </div>
                                                </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endfor
                                    </div>
                                <div id="blogListInfo" class="blog-card-hidden">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
    <script src="{{ asset('theme-assets/js/custom.js') }}"></script>
    <script>
        $(".blog-card-hidden").addClass('hidden');
        $("#shimmer-blog").removeClass('hidden');
        $.ajax({
            type: 'get',
            url: '{{ route('api.blog.list') }}',
            success: function(res) {
                var html = '';
                $(".blog-card-hidden").empty().append(html).removeClass('hidden');
                $("#shimmer-blog").addClass('hidden');
                if(res.status === "ok") {
                    for(var i = 0; i < res.data.length; i++) {
                        html += '<a href="' + res.data[i].href + '"><div class="container p-0 m-0 py-3">';
                        html += '<div class="row p-0 m-0">';
                        html += '<div class="col-4 p-0 m-0">';
                        html += '<div class="imgResponsive"><img class="blogImgSize" src="' + res.data[i].img + '" alt="' + res.data[i].alt + '"></div>';
                        html += '</div>'
                        html += '<div class="col-8 p-0 m-0">';
                        html += '<div style="height: 60px" class="d-flex justify-content-start align-items-center" >';
                        html += '<h6 class="fontSize12 bold pr-15 overFlowHidden lineHeight2 colorBlack">' + res.data[i].header + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div></a>';
                        html += '<hr>';
                    }
                    $("#blogListInfo").empty().append(html);
                }
            }
                });
    </script>
@stop