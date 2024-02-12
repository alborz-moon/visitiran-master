<!doctype html>
<html class="no-js" lang="en">

<head>

    @section('header')
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>پنل ادمین</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- favicon
                                ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-panel/img/logo.png') }}">
        <!-- Google Fonts
                                ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
        <!-- Bootstrap CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/font-awesome.min.css') }}">

        <!-- adminpro icon CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/adminpro-custon-icon.css') }}">

        <!-- meanmenu icon CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/meanmenu.min.css') }}">

        <!-- mCustomScrollbar CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/jquery.mCustomScrollbar.min.css') }}">

        <!-- animate CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/modal.css') }}">

        <!-- jvectormap CSS
                                ============================================ -->
        {{--        <link rel="stylesheet" href="{{asset('admin-panel/css/jvectormap/jquery-jvectormap-2.0.3.css')}}"> --}}

        <!-- normalize CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/data-table/bootstrap-editable.css') }}">

        <link rel="stylesheet" href="{{ asset('admin-panel/css/accordions.css') }}">

        <!-- normalize CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/normalize.css') }}">
        <!-- charts CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/tabs.css') }}">
        <!-- style CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/style.css') }}">
        <!-- responsive CSS
                                ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/common.css?v=1.2') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/commonCSS.css') }}">
        <link rel="stylesheet" href="{{ asset('theme-assets/css/fontface.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- modernizr JS
                                ============================================ -->
        <script src="{{ asset('admin-panel/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <script src="{{ asset('admin-panel/js/jquery.min.js') }}"></script>
        <link href="{{ asset('theme-assets/css/dependencies/iziToast.min.css') }}" rel="stylesheet" />

        <script>
            function validateNumber(evt) {
                var theEvent = evt || window.event;

                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                    // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }
        </script>
    @show

</head>

<body class="darklayout">

    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Header top area start-->
    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <a
                        href="{{ request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE ? route('home') : route('event.home') }}"><img
                            src="{{ asset('theme-assets/images/avatar/default.png') }}" alt="">
                    </a>
                    <h3>پنل ادمین</h3>
                </div>
                <div class="left-custom-menu-adp-wrap">
                    @if (Auth::check())
                        <ul class="nav navbar-nav left-sidebar-menu-pro">
                            @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">تنظیمات
                                            سیستمی</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('category.index') }}" class="dropdown-item">مدیریت دسته
                                            ها</a>
                                        <a href="{{ route('brand.index') }}" class="dropdown-item">مدیریت برند ها</a>
                                        <a href="{{ route('config.index') }}" class="dropdown-item">پیکربندی</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">مدیریت
                                            محتوا</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('faq.index') }}" class="dropdown-item">مدیریت سوالات
                                            متداول</a>
                                        <a href="{{ route('blog.index') }}" class="dropdown-item">مدیریت بلاگ ها</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">مدیریت
                                            تبلیغات</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('infobox.index') }}" class="dropdown-item">مدیریت بنر
                                            هدر</a>
                                        <a href="{{ route('slider.index') }}" class="dropdown-item">مدیریت
                                            اسلایدر</a>
                                        <a href="{{ route('banner.index') }}" class="dropdown-item">مدیریت بنر های
                                            تبلیغاتی</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">کاربران</span>
                                        <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('users.index', ['level' => 'admin']) }}"
                                            class="dropdown-item">ادمین ها</a>
                                        <a href="{{ route('users.index', ['level' => 'editor']) }}"
                                            class="dropdown-item">ویرایش کنندگان</a>
                                        <a href="{{ route('users.index', ['level' => 'report']) }}"
                                            class="dropdown-item">گزارش گیرندگان</a>
                                        <a href="{{ route('users.index', ['level' => 'finance']) }}"
                                            class="dropdown-item">گزارش گیرندگان مالی</a>
                                        <a href="{{ route('users.index', ['level' => 'news']) }}"
                                            class="dropdown-item">مدیریت بلاگها</a>
                                        <a href="{{ route('seller.index') }}" class="dropdown-item">فروشندگان</a>
                                        <a href="{{ route('mail.users') }}" class="dropdown-item">خبرنامه</a>
                                    </div>
                                </li>


                                <li class="nav-item"><a href="{{ route('basket-report') }}" role="button"
                                        class="nav-link"><i></i> <span class="mini-dn">گزارش گیری</span></a></li>

                                <li class="nav-item"><a href="{{ route('off.index') }}" role="button"
                                        class="nav-link"><i></i> <span class="mini-dn">تخفیفات</span></a></li>
                                <li class="nav-item"><a href="{{ route('product.index') }}" role="button"
                                        class="nav-link"><i></i> <span class="mini-dn">مدیریت محصولات</span></a></li>
                            @else
                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">تنظیمات
                                            سیستمی</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('config.index') }}" class="dropdown-item">پیکربندی</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">مدیریت
                                            محتوا</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('facilities.index') }}" class="dropdown-item">مدیریت
                                            امکانات ویژه</a>
                                        <a href="{{ route('eventTags.index') }}" class="dropdown-item">مدیریت تگ
                                            ها</a>
                                        <a href="{{ route('blog.index') }}" class="dropdown-item">مدیریت بلاگ ها</a>
                                        <a href="{{ route('faq.index') }}" class="dropdown-item">مدیریت سوالات
                                            متداول</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">کاربران</span>
                                        <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('users.index', ['level' => 'admin']) }}"
                                            class="dropdown-item">ادمین ها</a>
                                        <a href="{{ route('users.index', ['level' => 'editor']) }}"
                                            class="dropdown-item">ویرایش کنندگان</a>
                                        <a href="{{ route('users.index', ['level' => 'report']) }}"
                                            class="dropdown-item">گزارش گیرندگان</a>
                                        <a href="{{ route('users.index', ['level' => 'finance']) }}"
                                            class="dropdown-item">گزارش گیرندگان مالی</a>
                                        <a href="{{ route('users.index', ['level' => 'news']) }}"
                                            class="dropdown-item">مدیریت بلاگها</a>
                                        <a href="{{ route('launcher.index') }}" class="dropdown-item">برگزار
                                            کنندگان</a>
                                        <a href="{{ route('mail.users') }}" class="dropdown-item">خبرنامه</a>
                                    </div>
                                </li>

                                <li class="nav-item"><a data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle"><i></i> <span class="mini-dn">مدیریت
                                            تبلیغات</span> <span class="indicator-right-menu mini-dn"><i
                                                class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        <a href="{{ route('infobox.index') }}" class="dropdown-item">مدیریت بنر
                                            هدر</a>
                                        <a href="{{ route('slider.index') }}" class="dropdown-item">مدیریت
                                            اسلایدر</a>
                                        <a href="{{ route('banner.index') }}" class="dropdown-item">مدیریت بنر های
                                            تبلیغاتی</a>
                                    </div>
                                </li>


                                <li class="nav-item"><a href="{{ route('off.index') }}" role="button"
                                        class="nav-link"><i></i> <span class="mini-dn">تخفیفات</span></a></li>
                                <li class="nav-item"><a href="{{ route('event.index') }}" role="button"
                                        class="nav-link"><i></i> <span class="mini-dn">رویدادها</span></a></li>
                            @endif

                            <li class="nav-item"><a href="{{ route('logout') }}" role="button"
                                    class="nav-link"><i></i> <span class="mini-dn">خروج</span></a></li>
                        </ul>
                    @endif
                </div>
            </nav>
        </div>

        <div class="content-inner-all-fa">
            @yield('content')
        </div>

        <div id="myModal"
            class="modal hidden modal-adminpro-general fullwidth-popup-InformationproModal fade bounceInDown animated in">
            <div class="modal-content">
                <input type="hidden" value="" id="slideId" name="id">
                <input type="hidden" value="delete" name="kind">
                <h2 style="padding-right: 5%;">ایا اطیمنان دارید؟</h2>
                <div class="flex center gap10">
                    <input type="submit" value="بله" class="btn green"
                        style="margin-right: 5px; margin-bottom: 3%" onclick="remove()">
                    <input type="button" value="انصراف" class="btn green"
                        style="margin-bottom: 3%; margin-left: 5px;" onclick="$('#myModal').addClass('hidden')">
                </div>
            </div>
        </div>



        @section('reminder')
            <!-- jquery
                            ============================================ -->
            <script src="{{ asset('admin-panel/js/vendor/jquery-1.11.3.min.js') }}"></script>
            <!-- bootstrap JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/bootstrap.min.js') }}"></script>
            <!-- meanmenu JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.meanmenu.js') }}"></script>
            <!-- mCustomScrollbar JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
            <!-- sticky JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.sticky.js') }}"></script>
            <!-- scrollUp JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.scrollUp.min.js') }}"></script>
            <!-- scrollUp JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/wow/wow.min.js') }}"></script>
            <!-- counterup JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/counterup/jquery.counterup.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/counterup/waypoints.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/counterup/counterup-active.js') }}"></script>
            <!-- jvectormap JS
                                    ============================================ -->
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script> --}}
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jvectormap-active.js')}}"></script> --}}
            <!-- peity JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/peity/jquery.peity.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/peity/peity-active.js') }}"></script>
            <!-- sparkline JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/sparkline/jquery.sparkline.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/sparkline/sparkline-active.js') }}"></script>
            <!-- flot JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/flot/Chart.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/flot/dashtwo-flot-active.js') }}"></script>
            <!-- data table JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/tableExport.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/data-table-active.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-editable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-editable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-resizable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/colResizable-1.5.source.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-export.js') }}"></script>

            <script src="{{ asset('admin-panel/js/dropzone.js') }}"></script>
            <script src="{{ asset('admin-panel/js/multiple-email-active.js') }}"></script>
            <script src="{{ asset('admin-panel/js/summernote.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/summernote-active.js') }}"></script>

            <!-- main JS
                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/main.js') }}"></script>
            <script src="{{ asset('theme-assets/js/dependencies/iziToast.min.js') }}"></script>

            <script type="text/javascript">
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


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {

                        var errs = JSON.parse(XMLHttpRequest.responseText).errors;

                        if (errs instanceof Object) {
                            var errsText = '';

                            Object.keys(errs).forEach(function(key) {
                                errsText += errs[key] + "<br />";
                            });

                            showErr(errsText);
                        } else {
                            var errsText = '';

                            for (let i = 0; i < errs.length; i++)
                                errsText += errs[i].value;

                            showErr(errsText);
                        }
                    }
                });

                function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }

                function isEN(evt) {
                    // return /^[a-zA-Z]+$/.test(evt.);
                }

                let removeURL;
                let itemID;
                let item;

                function removeModal(node, id, url, ) {
                    $("#myModal").removeClass('hidden');
                    removeURL = url;
                    itemID = id;
                    item = node;
                }

                function remove() {

                    $.ajax({
                        type: 'delete',
                        url: removeURL,
                        headers: {
                            "Accept": "application/json"
                        },
                        success: function(res) {
                            if (res.status === "ok") {
                                $("#myModal").addClass('hidden');
                                showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                                $("#" + item + "_" + itemID).remove();
                            } else
                                showErr(res.msg);
                        }
                    })

                }
            </script>

        @show
    </div>
</body>
