
@extends('layouts.structure')
@section('content')
        <main class="page-content">
            <div class="container">
                <div class="row mb-5">
                        @include('shop.profile.layouts.profile_menu')     
                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <div class="ui-box bg-white mb-5">
                            <div class="ui-box-title">
                                پیغام
                            </div>
                            <div class="ui-box-empty-content">
                                <div class="ui-box-empty-content-icon">
                                    <img src="./theme-assets/images/theme/notification.svg" alt="">
                                </div>
                                <div class="ui-box-empty-content-message">
                                    پیامی برای نمایش وجود ندارد
                                </div>
                            </div>
                        </div>
                    </div>
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