
@extends('layouts.structure-login')
@section('content')
        <main class="page-content page-auth">
        <!-- start of auth-container -->
        <div class="auth-container">

            <!-- start of auth-box -->
            <div class="auth-box ui-box pt-0">
                <div class="d-flex">
                    <div class="logo-container logo-box me-3 logoImgFromTop">
                        @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                            <img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="120" alt="">
                        @else
                            <img src="{{ asset('theme-assets/images/menuImage.png') }}" width="110" alt="">
                        @endif
                    </div>
                    <div>
                        @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                            <div class="notification-item--text colorYellow bold"> بازارگاه صنایع دستی </div>
                            <div class="notification-item--text fontSize12"> سامانه فروش صنایع دستی و هنرهای تزئینی </div>
                        @else
                            <div class="notification-item--text colorYellow bold">ویزیت ایران</div>
                            <div class="notification-item--text fontSize12">دبیرخانه رویدادها</div>
                        @endif
                        <div class="notification-item--text fontSize18 bold mt-3 mb-3">خوش آمدید</div>
                    </div>
                </div>
                <div class="fs-6 fw-bold text-dark text-center mb-3">حساب کاربری شما ساخته شد</div>
                <div class="fs-7 fw-bold text-muted text-center mb-3">
                    اکنون می‌توانید به صفحه‌ای که در آن بودید بازگردید و یا با تکمیل اطلاعات حساب کاربری خود به کلیه
                    امکانات و سرویس‌ها و سرویس‌های وابسته به آن دسترسی داشته باشید
                </div>
                <a href='{{ route('profile.personal-info') }}' class="btn btn-block btn-primary mb-3"><i class="ri-user-6-fill me-2"></i> تکمیل حساب
                    کاربری</a>
                <div class="text-center">
                    {{-- {{ $is_in_event ? route('event.home') : route('home') }} --}}
                    <span id="comeBackLastPage" class="hoverBoldYellow cursorPointer colorYellow">بازگشت به صفحه‌ای که در آن بودید</span>
                </div>
            </div>
            <!-- end of auth-box -->
        </div>
        <!-- end of auth-container -->
    </main>
@stop

@section('extraJS')
    @parent
    <script>
        $("#comeBackLastPage").on('click', function() {
            let url = localStorage.getItem("url");
            if(url === undefined || url === null) return;
            location.href = url;
        });
            
    </script>
@stop