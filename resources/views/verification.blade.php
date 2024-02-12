
@extends('layouts.structure-login')
@section('content')
            <main class="page-content page-auth">
            <!-- start of auth-container -->
            <div class="auth-container">
                {{-- <div class="mt-3 mb-3">رمز یکبار مصرف به شماره تلفن 09121111111 ارسال شد. </div> --}}
                <!-- start of auth-box -->
                <div class="auth-box ui-box pt-0">
                    <div class="d-flex">
                        <div class="logo-container logo-box me-3 logoImgFromTop">
                            @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                                <img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="120" alt="">
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
                    <!-- start of form-element -->
                    <div class="form-element-row mb-3">
                        <p>
                            برای ایجاد
                            حساب
                            کاربری/ ورود، لطفا
                            کد ارسال شده را وارد نمایید.
                        </p>
                    </div>
                    <!-- end of form-element -->
                    <!-- start of form-element -->
                    <div class="form-element-row mb-3">
                        <div class="form-input-code-container fa-num">
                            <input type="text" maxlength="2" class="form-control input-code" id="input-code-0"
                                data-next="1" autocomplete="off" autofocus>
                            <span class="divider">-</span>
                            <input type="text" maxlength="2" class="form-control input-code" id="input-code-1"
                                data-next="2" autocomplete="off">
                            <span class="divider">-</span>
                            <input type="text" maxlength="2" class="form-control input-code" id="input-code-2"
                                autocomplete="off">
                        </div>
                    </div>
                    <!-- end of form-element -->
                    <!-- start of verify-code-wrapper -->
                    <div  class="verify-code-wrapper mt-3 mb-5">
                        <div id="timer" class="d-flex align-items-center" dir="ltr">
                            <span class="text-sm">مدت زمان باقیمانده</span>
                            <span class="mx-2">|</span>
                            <div id="timer--verify-code"></div>
                        </div>
                        <a id="send-again-btn" style="cursor: pointer" class="send-again hoverBoldYellow colorYellow">ارسال مجدد</a>
                    </div>
                    <!-- end of verify-code-wrapper -->
                    <!-- start of form-element -->
                    <div class="form-element-row mb-3">
                        <button id="confirmBtn" type="submit" class="btn btn-primary">پیوستن به خانواده ما</button>
                    </div>
                    <!-- end of form-element -->
                    <!-- start of form-element -->
                    <div class="form-element-row">
                        <a href="{{ route('login-register') }}" class="hoverBoldYellow colorYellow mx-auto">ویرایش شماره موبایل <i class="ri-pencil-fill ms-1"></i></a>
                    </div>
                    
                    <!-- end of auth-form -->
                </div>
                <!-- end of auth-box -->
            </div>
            <!-- end of auth-container -->
        </main>
    <script>
        
        let timer;
        let phone;
        let createdAt;

        $(document).ready(function() {
            
            createdAt = window.localStorage.getItem("createdAt");
            phone = window.localStorage.getItem("phone");
            timer = window.localStorage.getItem("reminder");
            
            $('#timer--verify-code').attr('data-seconds-left', timer - (Date.now() - createdAt) / 1000);

            $("#confirmBtn").on('click', function() {
                
                var code = $("#input-code-0").val() + $("#input-code-1").val() +  $("#input-code-2").val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('api.signup.verify') }}',
                    data: {
                        code: code,
                        phone: phone
                    },
                    success: function(res) {
                        if(res.status === "ok") {
                            document.location.href = '{{ route('come') }}';
                        }
                    }
                });
            });

            $("#send-again-btn").on('click', function() {

                $.ajax({
                    type: 'post',
                    url: '{{ route('api.login') }}',
                    data: {
                        phone: phone
                    },
                    success: function(res) {
                        if(res.status === "ok") {
                            reminder = res.reminder;
                            createdAt = Date.now();
                            window.localStorage.setItem("reminder", res.reminder);
                            window.localStorage.setItem("createdAt", Date.now());

                            $('#timer--verify-code').attr('data-seconds-left', timer - (Date.now() - createdAt) / 1000);
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