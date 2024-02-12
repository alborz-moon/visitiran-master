<!DOCTYPE html>
<html lang="fa">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#0089B7">
	<meta name="msapplication-navbutton-color" content="#0089B7">
	<meta name="apple-mobile-web-app-status-bar-style" content="#0089B7">
	{{-- logo --}}
	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('theme-assets/images/logo/apple-icon-57x57.png') }}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('theme-assets/images/logo/apple-icon-60x60.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('theme-assets/images/logo/apple-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('theme-assets/images/logo/apple-icon-76x76.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('theme-assets/images/logo/apple-icon-114x114.png') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('theme-assets/images/logo/apple-icon-120x120.png') }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('theme-assets/images/logo/apple-icon-144x144.png') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('theme-assets/images/logo/apple-icon-152x152.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('theme-assets/images/logo/apple-icon-180x180.png') }}">
	<link rel="icon" type="image/png" sizes="192x192"
		href="{{ asset('theme-assets/images/logo/android-icon-192x192.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('theme-assets/images/logo/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('theme-assets/images/logo/favicon-96x96.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('theme-assets/images/logo/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('manifest.json') }}">
	<meta name="msapplication-TileColor" content="#00B2BC">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#00B2BC">
	{{-- logo --}}

	<link rel="stylesheet" href="{{ asset('theme-assets/css/dependencies.css') }}">
	<link rel="stylesheet" href="{{ asset('theme-assets/css/theme.css') }}">
	<link rel="stylesheet" href="{{ asset('theme-assets/css/visitiran.css') }}">
	<link rel="stylesheet" href="{{ asset('theme-assets/css/fontface.css') }}">
	<link rel="stylesheet" href="{{ asset('theme-assets/css/custom.css?v=1.4') }}">

	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<script src="{{ asset('theme-assets/js/dependencies/jquery-3.6.0.min.js') }}"></script>
	@section('seo')
		@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
			<title>بازارگاه صنایع دستی | خانه</title>
			<meta property="og:title" content="از ایران ویزیت" />
			<meta name="twitter:title" content="از ایران ویزیت" />
			<meta property="og:site_name" content="از ایران ویزیت" />
			<meta property="og:image" content="از ایران ویزیت" />
			<meta property="og:image:secure_url" content="از ایران ویزیت" />
			<meta name="twitter:image" content="از ایران ویزیت" />
			<meta property="og:description" content="از ایران ویزیت" />
			<meta name="twitter:description" content="از ایران ویزیت" />
			<meta name="description" content="از ایران ویزیت" />
			<meta name="keywords" content="از ایران ویزیت" />
		@else
			<title>ویزیت ایران | خانه</title>
			<meta property="og:title" content="از ایران ویزیت" />
			<meta name="twitter:title" content="از ایران ویزیت" />
			<meta property="og:site_name" content="از ایران ویزیت" />
			<meta property="og:image" content="از ایران ویزیت" />
			<meta property="og:image:secure_url" content="از ایران ویزیت" />
			<meta name="twitter:image" content="از ایران ویزیت" />
			<meta property="og:description" content="از ایران ویزیت" />
			<meta name="twitter:description" content="از ایران ویزیت" />
			<meta name="description" content="از ایران ویزیت" />
			<meta name="keywords" content="از ایران ویزیت" />
		@endif
	@show

	@section('header')
	@show
</head>

<body>

	<div class="page-wrapper">
		<!-- start of page-header -->
		<header class="page-header d-md-block d-none customFixedMenu">
			{{-- @include('layouts.top-banner') --}}
			<!-- start banner -->
			<div class="alert banner-container alert-dismissible fade show showTopBanner hidden" role="alert"
				id="topBanner">
				<a href="#" target="_blank" id="" class="banner-placement rounded-0 infobox"
					style="height: 60px;"></a>
				<button id="close" type="button" class="btn-close customCloseIconBanner p-0" data-bs-dismiss="alert"
					aria-label="Close"></button>
			</div>
			<!-- end banner -->
			<!-- start of page-header-middle -->
			<div class="page-header--middle customBackgroundWhite">
				<div class="container heightHeader customBackgroundWhite">
					<div class="d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center flex-grow-1 pe-3 zIndex3 position-relative">

							@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
								<div class="logo-container logo-box me-3 positionAbsolute logoImgFromTop padding3">
									<img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="90" alt="">
								</div>
							@else
								<div class="logo-container logo-box me-3 positionAbsolute logoImgFromTop">
									<img src="{{ asset('theme-assets/images/menuImage.png') }}" width="110" alt="">
								</div>
							@endif

							@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
								<div class="marginFromRightHeaderShop">
									<div class="notification-item--text colorYellow bold"> بازارگاه صنایع دستی </div>
									<div class="notification-item--text fontSize12 bold"> سامانه فروش صنایع دستی و
										هنرهای تزئینی </div>
								</div>
							@else
								<div class="marginFromRightHeaderEvent">
									<div class="notification-item--text colorYellow bold">ویزیت ایران</div>
									<div class="notification-item--text fontSize12 bold">دبیرخانه رویدادها</div>
								</div>
							@endif
						</div>
						<div class="user-options heightHeader customFilterGray">
							<div class="user-option user-option--search customBorderLeft1" data-remodal-target="search-modal">
								<button class="user-option-btn user-option-btn--search gap10 b-0 btnHover" data-remodal-target="search-modal">
									<i class="icon-visit-search customHeader textColor btnHover" data-remodal-target="search-modal"></i>
								</button>
							</div>
							@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
								<div class="user-option user-option--cart customBorderLeft1">
									<a href="{{ route('cart') }}" class="user-option-btn user-option-btn--cart">
										<i class="icon-visit-basket customHeader colorYellow customBasket"></i>
										<div id="basketItems" class="addBasket hidden"></div>
									</a>
									<div class="mini-cart">
										<div class="mini-cart-header b-0">
											<span id="basket-items-count" class="mini-cart-products-count fa-num"></span>
											<a href="{{ route('cart') }}" class="btn btn-link px-0">مشاهده سبد خرید
												<i class="ri-arrow-left-s-fill"></i></a>
										</div>
										<div id="basket-items" style="max-height: 350px; overflow: auto"></div>
										<div class="mini-cart-footer b-0">
											<div class="mini-cart-total">
												<span class="mini-cart-total-label">مبلغ قابل پرداخت:</span>
												<span id="mini-cart-total-value" class="mini-cart-total-value fa-num"><span
														class="currency">تومان</span></span>
											</div>
											@if (Auth::check())
												<a href="{{ route('cart') }}" class="btn btn-primary">ثبت سفارش</a>
											@else
												<a href="{{ route('login-register') }}" class="btn btn-primary">ورود
													و ثبت سفارش</a>
											@endif
										</div>
									</div>
								</div>
							@endif
							<div class="user-option user-option--account  paddingRight15 btnHover">
								@if (!Auth::check())
									<a href="{{ route('login-register') }}"
										class="user-option-btn user-option-btn--account gap10 hoverGold textColor setLinkUrl">
										<i class="icon-visit-person customHeader"></i>ورود / ثبت نام
									</a>
								@else
									<a href="{{ route('profile.personal-info') }}"
										class="user-option-btn user-option-btn--account gap10 hoverGold textColor">
										<i class="icon-visit-person customHeader"></i>صفحه شخصی
									</a>
									<div class="user-option--dropdown user-option--dropdown-right">
										<div class="profile-user-info ui-box customUiBox">
											<div class="profile-detail">
												<div class="d-flex align-items-center">
													<div class="profile-info">
														<a href="#" class="text-decoration-none text-dark fw-bold mb-2">
															{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
														</a>
													</div>
												</div>
											</div>
											<ul class="nav nav-items-with-icon flex-column">
												<li class="nav-item">
													@if (request()->getHost() == \App\Http\Controllers\Controller::$EVENT_SITE)
														<a class="nav-link" href="{{ route('my-events') }}"><i class="nav-link-icon ri-file-list-3-line"></i>
															بلیت های من
														</a>
													@else
														<a class="nav-link" href="{{ route('cart') }}"><i class="nav-link-icon ri-file-list-3-line"></i>
															سفارش
															های من
														</a>
													@endif
												</li>
												@if (Auth::check() && Auth::user()->isEditor())
													<li class="nav-item">
														<a class="nav-link"
															href="{{ request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE ? route('shop.panel') : route('event.panel') }}"><i
																class="nav-link-icon ri-file-list-3-line"></i>
															پنل ادمین
														</a>
													</li>
												@endif
												<li class="nav-item">
													<a class="nav-link" href="{{ route('logout') }}"><i class="nav-link-icon ri-logout-box-r-line"></i>
														خروج
													</a>
												</li>
											</ul>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end of page-header-middle -->
			<!-- start of page-header-top -->
			<div class="page-header--top backGray">
				<div class="container">
					<div class="d-flex align-items-center justify-content-between">
						<div class="page-header--top-right">
							<!-- start of page-header-bottom -->
							<div class="page-header--bottom marginFromRightHeader">
								<div class="container">
									<div class="d-flex align-items-center">
										<ul class="nav">
											<li class="nav-item">
												@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
													<a class="custom-nav-link hoverBold1 colorWhite" href="{{ route('home') }}"><img class="iconSvg"
															src="{{ asset('theme-assets/images/svg/home.svg') }}" alt="">صفحه اصلی</a>
												@else
													<a class="custom-nav-link hoverBold1 colorWhite" href="{{ route('event.home') }}"><img class="iconSvg"
															src="{{ asset('theme-assets/images/svg/home.svg') }}" alt="">صفحه اصلی</a>
												@endif
											</li>
											@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
												<li class="nav-item align-self-center">
													<div class="vertical-menu minWidthUnset">
														<a class="vertical-menu-btn p-0 m-0 colorWhite fontNormal cursorPointer hoverBold1"><img class="iconSvg"
																src="{{ asset('theme-assets/images/svg/headline.svg') }}" alt="">دسته بندی کالاها</a>
														<div class="vertical-menu-items marginFromRightHeaderNegative custom-vertical-menu-items zIndex2 mt-10">
															@include('layouts.menu')
														</div>
													</div>
												</li>
												<li class="nav-item">
													<a class="custom-nav-link hoverBold1 colorWhite fontNormal"
														href="{{ route('category.list', ['orderBy' => 'createdAt']) }}"><img class="iconSvg customIconTag"
															src="{{ asset('theme-assets/images/svg/label.svg') }}" alt="">پیشنهاد های ویژه</a>
												</li>
											@endif

											@if (request()->getHost() == \App\Http\Controllers\Controller::$EVENT_SITE)
												<li class="nav-item">
													<a class="custom-nav-link hoverBold1 colorWhite fontNormal"
														href="{{ route('event.category.list', ['createAt']) }}">رویداد
														ها</a>
												</li>
												<li class="nav-item">
													<a class="custom-nav-link hoverBold1 colorWhite fontNormal"
														href="{{ route('launcher-list') }}">برگزارکننده</a>
												</li>
												<li class="nav-item">
													<a class="custom-nav-link hoverBold1 colorWhite fontNormal" href="{{ route('create-event') }}">ایجاد
														رویداد</a>
												</li>
											@endif

										</ul>
									</div>
								</div>
							</div>
							<!-- end of page-header-bottom -->
						</div>
						<div class="page-header--top-left">
							<ul class="nav nav-light justify-content-end">
								@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
									<li class="nav-item d-md-none d-lg-block">
										<a class=" custom-nav-link colorWhite hoverBold1" href="{{ route('blog-list') }}">تازه‌ها</a>
									</li>
									<li class="nav-item">
										<a class=" custom-nav-link colorWhite hoverBold1"
											href="https://hcshop.taci.ir/blog/12/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87_%D9%85%D8%A7">درباره
											ما</a>
									</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- end of page-header-top -->
		</header>
		<!-- end of page-header -->
		<header class="page-header-responsive d-md-none p-0">

			<!-- start banner -->

			<div class="alert banner-container alert-dismissible fade show showTopBanner hidden" role="alert"
				id="topBanner">
				<a href="#" target="_blank" id="" class="banner-placement rounded-0 infobox"
					style="height: 60px;"></a>
				<button id="close" type="button" class="btn-close customCloseIconBanner p-0 " data-bs-dismiss="alert"
					aria-label="Close"></button>
			</div>

			<!-- end banner -->

			<div class="page-header-responsive-row">
				<div class="d-flex align-items-center">
					<div class="navigation-container zIndex5">
						<div class="navigation">
							<div class="navigation-header">
								<div class="logo-container logo-box p-0">
									<a href="#" class="d-flex flexDirectionRow logo alignItemsStart p-2">
										@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
											<div><img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="110" alt=""></div>
											<div class="logo-text colorBlue d-flex alignSelfCenter mx-2">دسته بندی
												کالاها<img class="iconSvg" src="{{ asset('theme-assets/images/svg/headline.svg') }}" alt="">
											</div>
										@else
											<div class="logo-text colorBlue d-flex alignSelfCenter mx-2">دبیرخانه
												رویدادها<img class="iconSvg" src="{{ asset('theme-assets/images/svg/headline.svg') }}" alt="">
											</div>
											<div><img class="headerImageEvent" src="{{ asset('theme-assets/images/menuImage.png') }}" width="120"
													alt=""></div>
										@endif
									</a>
								</div>
							</div>
							<div class="navigation-body">
								<ul id="moblieMenu" class="menu">
									@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
										@include('layouts.mobile-menu')
									@else
										<li>
											<a href="{{ route('event.home') }}">صفحه اصلی</a>
										</li>
										<li>
											<a href="{{ route('event.category.list', ['createAt']) }}">رویداد ها</a>
										</li>
										<li>
											<a href="{{ route('launcher-list') }}">برگزارکننده</a>
										</li>
										<li>
											<a href="{{ route('create-event') }}">رویداد جدید</a>
										</li>
									@endif
								</ul>
							</div>
						</div>

						<div class="navigation-overlay">
							<div class="position-absolute t-0 l-0 ">
								<button type="button" class="btn-close customCloseIconBanner p-0"></button>
							</div>
						</div>

					</div>

					<div class="d-flex align-items-center flex-grow-1 pe-3 zIndex3 position-relative">

						@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
							<div
								class="logo-container logo-box me-3 positionAbsolute logoImgFromTop marginTop14 d-flex justifyContentCenter p-0">
								<img src="{{ asset('theme-assets/images/menuImage2.svg') }}" width="70" alt="">
							</div>
						@else
							<div class="logo-container logo-boxEvent me-3 positionAbsolute logoImgFromTop backColorWhite">
								<img class="headerImgMT15" src="{{ asset('theme-assets/images/menuImage.png') }}" width="80"
									alt="">
							</div>
						@endif

						@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
							<div class="marginFromRightHeader">
								<div class="notification-item--text colorYellow bold"> بازارگاه صنایع دستی </div>
								<div class="notification-item--text fontSize12 bold"> سامانه فروش صنایع دستی و هنرهای
									تزئینی </div>
							</div>
						@else
							<div class="marginFromRightHeader">
								<div class="notification-item--text colorYellow bold">ویزیت ایران</div>
								<div class="notification-item--text fontSize12 bold">دبیرخانه رویدادها</div>
							</div>
						@endif

					</div>
				</div>
			</div>
		</header>
		<div class="d-md-none p-0 wrapperMobileMenu">
			<div class="mobileMenu">
				<div class="customMobileMenuBoxShadow w-100 h-100">
					<div class="d-flex justify-content-center gap30">
						<button class="d-flex b-0 m-0 p-0 toggle-navigation">
							<div class="menuCircle">
								<div class="d-flex flexDirectionColumn justify-content-center align-items-center paddingTop8">
									<i class="icon-visit-menu fontSize30 colorBlack"></i>
									<div class="fontSize14 colorBlack whiteSpaceNoWrap">منو</div>
								</div>
							</div>
						</button>
						<button id="searchMobile" class="d-flex b-0 m-0 p-0">
							<div class="menuCircle">
								<div class="d-flex flexDirectionColumn justify-content-center align-items-center paddingTop8">
									<i class="icon-visit-search colorBlack fontSize30"></i>
									<div class="fontSize14 colorBlack whiteSpaceNoWrap">جست و جو</div>
								</div>
							</div>
						</button>
						@if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
							<a href="" class="d-flex b-0 m-0 p-0">
								<div class="menuCircle">
									<div class="d-flex flexDirectionColumn justify-content-center align-items-center paddingTop8">
										<i class="icon-visit-basket fontSize30 colorYellow"></i>
										<div class="fontSize14 colorBlack whiteSpaceNoWrap">سبد خرید</div>
									</div>
								</div>
							</a>
						@endif
						@if (!Auth::check())
							<a href="{{ route('login-register') }}" class="d-flex b-0 m-0 p-0 setLinkUrl">
								<div class="menuCircle">
									<div class="d-flex flexDirectionColumn justify-content-center align-items-center paddingTop8">
										<i class="icon-visit-person fontSize30 colorBlack"></i>
										<div class="fontSize14 colorBlack whiteSpaceNoWrap">ورود/ثبت نام</div>
									</div>
								</div>
							</a>
						@else
							<button id="userToggleMobile" class="d-flex b-0 m-0 p-0">
								<div class="menuCircle">
									<div class="d-flex flexDirectionColumn justify-content-center align-items-center paddingTop8">
										<i class="icon-visit-person fontSize30 colorBlack"></i>
										<div class="fontSize14 colorBlack whiteSpaceNoWrap">صفحه شخصی</div>
									</div>
								</div>
							</button>
						@endif
					</div>
				</div>
			</div>
		</div>
		{{-- route('product-search') --}}
		@include(
			'layouts.modal-search',
			[
				'route' =>
					request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE
						? route('product-search')
						: route('event-search'),
			],
			[
				'routeCat' =>
					request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE
						? route('category-search')
						: route('search-event-tag'),
			]
		)

		@if (Auth::check())
			@include('layouts.modal-user-mobile')
		@endif

		<div class="hidden" id="sample-mini-cart-products">
			@include('shop.product.mini_card')
		</div>
		<!-- start of page-content -->
		<div id="mainPageContent" class="mt-md-110">
			@yield('content')
		</div>
		<!-- end of page-content -->
	</div>
	@section('footer')
		@include('layouts.footer')
	@show

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
	<script src="{{ asset('theme-assets/js/basket.js') }}"></script>
	<script src="{{ asset('theme-assets/js/theme.js') }}"></script>
	<script src="{{ asset('theme-assets/js/custom.js') }}"></script>

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {

				var errs = XMLHttpRequest.responseJSON.errors;

				if (errs instanceof Object) {
					var errsText = '';

					Object.keys(errs).forEach(function(key) {
						errsText += errs[key] + "<br />";
					});

					showErr(errsText);
				} else {
					var errsText = '';

					if (errs !== undefined && errs !== null) {
						for (let i = 0; i < errs.length; i++)
							errsText += errs[i].value;
					}

					showErr(errsText);
				}
			}
		});

		$(document).ready(function() {
			refreshBasket();
		});

		Number.prototype.formatPrice = function(decPlaces, thouSeparator, decSeparator) {
			var n = this,
				decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
				decSeparator = decSeparator == undefined ? "." : decSeparator,
				thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
				sign = n < 0 ? "-" : "",
				i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
				j = (j = i.length) > 3 ? j % 3 : 0;
			return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" +
				thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
		};



		function isEmail(evt) {

			if (evt.key === '@' || evt.key === '.' || evt.key === '_' || evt.key === '-')
				return true;

			return /^[a-zA-Z]+$/.test(evt.key);
		}


		function isNumber(evt) {

			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}

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
		$(document).ready(function() {
			$(document).on('select2:open', (e) => {
				const selectId = e.target.id;
				$(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function(
					key, value, ) {
					value.focus();
				});
			});
			$('#close').on('click', function() {
				$('#SliderParent').addClass('marginTopMediaQuaryForSlider');
				$('.TopParentBannerMoveOnTop').addClass('marginTopMediaQuaryForSlider');
				$('.StickyMenuMoveOnTop').addClass('stickyTop')
			});

			function setUrl() {
				localStorage.setItem("url", location.href);
			}
			//when button clicked
			$(".setLinkUrl").on("click", setUrl);

		});
		var width = window.innerWidth;
		$.ajax({
			type: 'get',
			url: '{{ route('api.infobox') }}',
			headers: {
				'accept': 'application/json'
			},
			success: function(res) {
				if (res.status === "ok") {
					if (res.data.length === 0) {
						$(".showTopBanner").remove();
						$('.TopParentBannerMoveOnTop').css('marginTop', '-60px');
						$('.StickyMenuMoveOnTop').css('top', '90px');
						return;
					}
					$('.showTopBanner').removeClass('hidden');
					if (width > 1000) {
						$(".infobox").css('background-image', "url(" + res.data.img_large + ")").attr('href',
							res.data.href);
					} else if (width > 768) {
						$(".infobox").css('background-image', "url(" + res.data.img_mid + ")").attr('href', res
							.data.href);
					} else {
						$(".infobox").css('background-image', "url(" + res.data.img_small + ")").attr('href',
							res.data.href);
					}
				}
			}
		});
		const popover = new bootstrap.Popover('.example-popover', {
			container: 'body'
		});
	</script>
	@section('extraJS')
	@show
</body>

</html>
