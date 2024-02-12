@extends('layouts.structure')

@section('content')
        <main class="page-content">
        <div class="container">
            <div class="text-center">
                <div class="fs-5 fw-bold mb-3">چنین صفحه‌ای پیدا نشد</div>
                <div class="fs-6 fw-bold text-muted mb-4">با عرض پوزش از شما، چنین صفحه‌ای در سایت وجود ندارد یا این
                    صفحه از
                    سایت پاک
                    شده است.</div>
                <div class="mb-5">
                    <a href="{{ request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE ? route('home') : route('event.home') }}" class="btn btn-primary">برو به صفحه اصلی <i
                            class="ri-arrow-go-forward-line ms-2"></i></a>
                </div>
                <img src="./theme-assets/images/theme/404.png" class="img-fluid" alt="">
            </div>
        </div>
    </main>
@stop

@section('extraJS')
    @parent
    <script src="{{ asset('theme-assets/js/theme.js') }}"></script>
    <script src="{{ asset('theme-assets/js/custom.js') }}"></script>
@stop