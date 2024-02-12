
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
                                <img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="110" alt="">
                            @else
                                <img src="{{ asset('theme-assets/images/menuImage.png') }}" width="120" alt="">
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
                            <div class="notification-item--text fontSize18 bold mt-3 mb-3">ورود / ثبت نام</div>
                        </div>
                    </div>
                    <div ></div>
                    <div class="bold">سلام</div>
                    <div class="mb-4">لطفا شماره موبایل خود را وارد نمایید. </div>
                    <!-- start of auth-form -->
                    {{-- <form action="api/auth" class="auth-form" method=""> --}}
                        <!-- start of form-element -->
                        <div class="form-element-row mb-5">
                            <input onkeypress="return isEmail(event) || isNumber(event)" id="phone" type="text" class="form-control" placeholder="شماره موبایل">
                        </div>
                        <!-- end of form-element -->
                        <!-- start of form-element -->
                        <div class="form-element-row mb-3">
                            <button id="login_submit" class="btn btn-primary">ادامه</button>
                        </div>
                        <!-- end of form-element -->
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <div>با ورود و یا ثبت نام در سایت شما <a href="#">شرایط و
                                    قوانین</a> استفاده
                                از تمام سرویس های
                                سایت و <a href="#">قوانین حریم خصوصی</a> آن را می‌پذیرید.
                            </div>
                        </div>
                        <!-- end of form-element -->
                    {{-- </form> --}}
                    <!-- end of auth-form -->
                </div>
                <!-- end of auth-box -->
            </div>
            <!-- start of auth-container -->
        </main>
        <script>

            $(document).ready(function() {
                $("#login_submit").on('click', function() {
                
                    let phone = $('#phone').val();
                        
                    $.ajax({
                        type: 'post',
                        url: '{{ route('api.login') }}',
                        data: {
                            phone: phone
                        },
                        success: function(res) {
                            if(res.status === "ok") {
                                window.localStorage.setItem("phone", phone);
                                window.localStorage.setItem("createdAt", Date.now());
                                window.localStorage.setItem("reminder", res.reminder);
                                document.location.href = '{{route('verification')}}';
                            }
                        }
                    });
                });
            });
        </script>
@stop
@section('extraJS')
    @parent
@stop