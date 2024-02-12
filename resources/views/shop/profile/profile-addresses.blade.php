
@extends('layouts.structure')

@section('header')

    @parent

    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.js"></script>
    <link
      href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.css"
      rel="stylesheet"
    />

    <script>
        let step = 0;
        let x = undefined;
        let y = undefined;
        let mode = 'create';
        let selectedAddrId;
    </script>

@stop

@section('content')

    <main class="page-content TopParentBannerMoveOnTop">
        <div class="container mt-4">
            <div class="row mb-5">
                
                @include('shop.profile.layouts.profile_menu')     

                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="ui-box bg-white mb-5 pb-5">
                        <div class="ui-box-title">آدرس ها</div>
                        <div class="ui-box-content">
                            @include('shop.layouts.user-address-items')
                        </div>
                    </div>
                
                </div>

                @include('shop.layouts.modal-address')

            </div>
        </div>
    </main>
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
@stop