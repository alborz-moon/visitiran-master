<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#C59358">
    <meta name="msapplication-navbutton-color" content="#C59358">
    <meta name="apple-mobile-web-app-status-bar-style" content="#C59358">
    @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
        <title>بازارگاه صنایع دستی | خانه</title>
    @else
        <title>ویزیت ایران | خانه</title>
    @endif
    <link rel="stylesheet" href="{{ asset('theme-assets/css/dependencies.css') }}">
    <link rel="stylesheet" href="{{ asset('theme-assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{asset('theme-assets/css/fontface.css')}}">
    <link rel="stylesheet" href="{{ asset('theme-assets/css/custom.css') }}">
    
    <script src="{{ asset('theme-assets/js/dependencies/jquery-3.6.0.min.js') }}"></script>
</head>

<body>
    <div class="page-wrapper">
        <!-- start of page-content -->
        @yield('content')
        <!-- end of page-content -->
    </div>


    <script src="{{ asset('theme-assets/js/dependencies/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/jquery.simple.timer.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/iziToast.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/fancybox.umd.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/nouislider.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/wNumb.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/remodal.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/select2.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/dependencies/zoomsl.min.js') }}"></script>
    <script src="{{ asset('theme-assets/js/theme.js') }}"></script>
    <script src="{{ asset('theme-assets/js/custom.js') }}"></script>
    @section('extraJS')
    @show
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    
                var errs = XMLHttpRequest.responseJSON.errors;

                if(errs instanceof Object) {
                    var errsText = '';

                    Object.keys(errs).forEach(function(key) {
                        errsText += errs[key] + "<br />";
                    });

                    showErr(errsText);    
                }
                else {
                    var errsText = '';

                    if(errs !== undefined && errs !== null) {
                        for(let i = 0; i < errs.length; i++)
                            errsText += errs[i].value;
                    }
                    
                    showErr(errsText);
                }
            }
        });

         function showErr(msg) {
            s = {
                rtl: true,
                class: "iziToast-" + "danger",
                title: "ناموفق",
                message: msg,
                animateInside: !1,
                position: "topRight",
                progressBar: !1,
                icon: 'ri-close-fill',
                timeout: 3200,
                transitionIn: "fadeInLeft",
                transitionOut: "fadeOut",
                transitionInMobile: "fadeIn",
                transitionOutMobile: "fadeOut",
                color: "red",
                };
            iziToast.show(s);
        }

        function showSuccess(msg) {
            s = {
                rtl: true,
                class: "iziToast-" + "danger",
                title: "موفق!",
                message: msg,
                animateInside: !1,
                position: "topRight",
                progressBar: !1,
                icon: 'ri-check-fill',
                timeout: 3200,
                transitionIn: "fadeInLeft",
                transitionOut: "fadeOut",
                transitionInMobile: "fadeIn",
                transitionOutMobile: "fadeOut",
                color: "green",
                type: 'success'
                };
            iziToast.show(s);
        }
    </script>
</body>

</html>