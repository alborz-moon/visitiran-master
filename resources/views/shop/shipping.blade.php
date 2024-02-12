@extends('layouts.structure')

@section('header')

    @parent

    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.js"></script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.css" rel="stylesheet" />

    <script>
        let step = 0;
        let x = undefined;
        let y = undefined;
        let mode = 'create';
        let selectedAddrId;
    </script>

@stop

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-6 mb-lg-0 mb-4">
                    @include('shop.layouts.process', ['step' => 'shipping'])
                    <!-- start of box => user-address-selected -->
                    <div class="ui-box bg-white user-address-selected mb-5">
                        <div class="ui-box-title">آدرس تحویل سفارش</div>
                        <div class="ui-box-content">
                            @include('shop.layouts.user-address-items')
                        </div>
                    </div>
                    <!-- end of box => user-address-selected -->

                    @include('shop.layouts.modal-address')

                    <!-- start of box => user-addresses -->
                    <div class="ui-box bg-white user-addresses d-none mb-5" id="change-user-address">
                        <div class="ui-box-title">
                            آدرس تحویل سفارش را انتخاب نمایید:
                            <button class="ui-box-close" data-btn-box-close data-parent="#change-user-address"
                                data-show=".user-address-selected"><i class="ri-close-line"></i></button>
                        </div>
                        <div class="ui-box-content">
                            <!-- start of nav-tabs -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link fs-6 fw-bold active" id="nav-1-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1"
                                        aria-selected="true">
                                        آدرس های شما
                                    </button>
                                </div>
                            </nav>
                            <!-- end of nav-tabs -->
                            <!-- start of tab-content -->
                            <div class="tab-content" id="nav-tabContent">
                                <!-- start of tab-pane -->
                                <div class="tab-pane py-4 fade show active" id="nav-1" role="tabpanel"
                                    aria-labelledby="nav-1-tab">
                                    <!-- start of user-address-items -->
                                    <div class="user-address-items">
                                        <!-- start of user-address-item -->
                                        <div class="user-address-item">
                                            <div class="custom-radio-box">
                                                <input type="radio" class="custom-radio-box-input" name="userAddress"
                                                    id="userAddress01" checked>
                                                <label for="userAddress01" class="custom-radio-box-label"
                                                    data-placeholder="انتخاب به عنوان آدرس پیش فرض"
                                                    data-placeholder-checked="آدرس پیش فرض من است">
                                                    <span class="d-block user-address-recipient mb-2">خراسان
                                                        شمالی،بجنورد
                                                    </span>
                                                    <span class="d-block user-contact-items fa-num mb-3">
                                                        <span class="user-contact-item">
                                                            <i class="ri-mail-line icon"></i>
                                                            <span class="value">9999999999</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-phone-line icon"></i>
                                                            <span class="value">09xxxxxxxxx</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-user-line icon"></i>
                                                            <span class="value">جلال بهرامی راد</span>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex align-items-center justify-content-end">
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="remove-from-addresses-modal">حذف</a>
                                                        <span class="text-secondary mx-2">|</span>
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="edit-address-modal">ویرایش</a>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end of user-address-item -->
                                        <!-- start of user-add-address-btn-container -->
                                        <div class="user-address-item user-add-address-btn-container">
                                            <!-- <button class="user-add-address-btn"
                                                        data-remodal-target="add-address-modal-without-map">
                                                        <i class="ri-add-line icon"></i>
                                                        <span>آدرس جدید</span>
                                                    </button> -->
                                            <!-- <button class="user-add-address-btn"
                                                        data-remodal-target="add-address-modal-without-fields">
                                                        <i class="ri-add-line icon"></i>
                                                        <span>آدرس جدید</span>
                                                    </button> -->
                                            <button class="user-add-address-btn"
                                                data-remodal-target="add-address-modal-fields-with-map">
                                                <i class="ri-add-line icon"></i>
                                                <span>آدرس جدید</span>
                                            </button>
                                        </div>
                                        <!-- end of user-add-address-btn-container -->
                                    </div>
                                    <!-- end of user-address-items -->
                                </div>
                                <!-- end of tab-pane -->
                                <!-- start of tab-pane -->
                                <div class="tab-pane py-4 fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                    <!-- start of user-address-items -->
                                    <div class="user-address-items">
                                        <!-- start of user-address-item -->
                                        <div class="user-address-item">
                                            <div class="custom-radio-box">
                                                <input type="radio" class="custom-radio-box-input" name="userAddress"
                                                    id="userAddress04" checked>
                                                <label for="userAddress04" class="custom-radio-box-label"
                                                    data-placeholder="انتخاب به عنوان آدرس پیش فرض"
                                                    data-placeholder-checked="آدرس پیش فرض من است">
                                                    <span class="d-block user-address-recipient mb-2">خراسان
                                                        شمالی،بجنورد
                                                    </span>
                                                    <span class="d-block user-contact-items fa-num mb-3">
                                                        <span class="user-contact-item">
                                                            <i class="ri-mail-line icon"></i>
                                                            <span class="value">9999999999</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-phone-line icon"></i>
                                                            <span class="value">09xxxxxxxxx</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-user-line icon"></i>
                                                            <span class="value">جلال بهرامی راد</span>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex align-items-center justify-content-end">
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="remove-from-addresses-modal">حذف</a>
                                                        <span class="text-secondary mx-2">|</span>
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="edit-address-modal">ویرایش</a>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end of user-address-item -->
                                        <!-- start of user-address-item -->
                                        <div class="user-address-item">
                                            <div class="custom-radio-box">
                                                <input type="radio" class="custom-radio-box-input" name="userAddress"
                                                    id="userAddress05">
                                                <label for="userAddress05" class="custom-radio-box-label"
                                                    data-placeholder="انتخاب به عنوان آدرس پیش فرض"
                                                    data-placeholder-checked="آدرس پیش فرض من است">
                                                    <span class="d-block user-address-recipient mb-2">خراسان
                                                        شمالی،بجنورد
                                                    </span>
                                                    <span class="d-block user-contact-items fa-num mb-3">
                                                        <span class="user-contact-item">
                                                            <i class="ri-mail-line icon"></i>
                                                            <span class="value">9999999999</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-phone-line icon"></i>
                                                            <span class="value">09xxxxxxxxx</span>
                                                        </span>
                                                        <span class="user-contact-item">
                                                            <i class="ri-user-line icon"></i>
                                                            <span class="value">جلال بهرامی راد</span>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex align-items-center justify-content-end">
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="remove-from-addresses-modal">حذف</a>
                                                        <span class="text-secondary mx-2">|</span>
                                                        <a href="#" class="link border-bottom-0 fs-7 fw-bold"
                                                            data-remodal-target="edit-address-modal">ویرایش</a>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- end of user-address-item -->
                                    </div>
                                    <!-- end of user-address-items -->
                                </div>
                                <!-- end of tab-pane -->
                            </div>
                            <!-- end of tab-content -->
                        </div>
                    </div>
                    <!-- end of box => user-addresses -->
                    <!-- start of box => shipment-type -->
                    <div class="ui-box bg-white shipment-type mb-3">
                        <div class="ui-box-title">شیوه و زمان ارسال</div>
                        <div class="ui-box-content">
                            <!-- start of tab-content -->
                            <div class="tab-content" id="shipping-type-tabContent">
                                <!-- start of tab-pane -->
                                <div class="tab-pane fade show active" id="shipping-type-1" role="tabpanel"
                                    aria-labelledby="shipping-type-1">
                                    <!-- start of checkout-pack -->
                                    <div class="checkout-pack">
                                        <div class="checkout-pack-content">
                                            {{-- <div class="d-flex align-items-center mb-4"><i
                                                    class="ri-time-line text-muted me-2"></i> انتخاب زمان ارسال
                                            </div> --}}
                                            <!-- Slider main container -->
                                            <div class="swiper checkout-time-swiper-slider mb-5">
                                                <!-- Additional required wrapper -->
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
                                                    <div class="swiper-slide">
                                                        <div class="checkout-time fa-num">
                                                            <div class="checkout-time-label">پنج شنبه</div>
                                                            <div class="checkout-time-date">30 دی</div>
                                                            <div class="custom-radio-btn">
                                                                <input value="پنج شنبه 30 دی ساعت ۱۰ تا ۲۳" type="radio"
                                                                    class="custom-radio-btn-input" name="checkoutTime"
                                                                    id="checkoutTime02">
                                                                <label for="checkoutTime02"
                                                                    class="custom-radio-btn-label">
                                                                    <span class="label">
                                                                        بازه 10 تا 23
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="checkout-time fa-num">
                                                            <div class="checkout-time-label text-danger">جمعه</div>
                                                            <div class="checkout-time-date">1 بهمن</div>
                                                            <div class="custom-radio-btn">
                                                                <input value="جمعه ۱ بهمن ساعت ۱۰ تا ۲۳" type="radio"
                                                                    class="custom-radio-btn-input" name="checkoutTime"
                                                                    id="checkoutTime03">
                                                                <label for="checkoutTime03"
                                                                    class="custom-radio-btn-label">
                                                                    <span class="label">
                                                                        بازه 10 تا 23
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="checkout-time fa-num">
                                                            <div class="checkout-time-label">شنبه</div>
                                                            <div class="checkout-time-date">2 بهمن</div>
                                                            <div class="custom-radio-btn">
                                                                <input value="شنبه ۲ بهمن ساعت ۱۰ تا ۲۳" type="radio"
                                                                    class="custom-radio-btn-input" name="checkoutTime"
                                                                    id="checkoutTime04">
                                                                <label for="checkoutTime04"
                                                                    class="custom-radio-btn-label">
                                                                    <span class="label">
                                                                        بازه 10 تا 23
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- If we need navigation buttons -->
                                                <div class="swiper-button-prev"></div>
                                                <div class="swiper-button-next"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of checkout-pack -->
                                </div>
                                <!-- end of tab-pane -->
                            </div>
                            <!-- end of tab-content -->
                        </div>
                    </div>
                    <!-- end of box => shipment-type -->
                    <a href='{{ route('cart') }}' class="link border-bottom-0"><i class="ri-arrow-right-s-fill"></i>
                        بازگشت به سبد
                        خرید</a>
                </div>
                @include('shop.cart.basket_cart', ['nextBtnId' => 'saveAddrAndTimeBtn'])
            </div>
        </div>

    </main>
@stop

@section('extraJS')
    @parent

    <script src="{{ asset('theme-assets/js/basket.js') }}"></script>

    <script>
        renderPaymentCard();

        $(document).on('click', "#saveAddrAndTimeBtn", function() {

            let time = $("input[name='checkoutTime']:checked").val();

            if (time === undefined) {
                showErr('لطفا زمان تحویل موردنظر خود را انتخاب نمایید.');
                return;
            }

            let address = $("input[name='userAddress']:checked").val();

            if (address === undefined) {
                showErr('لطفا آدرس موردنظر خود را انتخاب نمایید.');
                return;
            }

            window.localStorage.setItem(
                "time", time
            );

            window.localStorage.setItem(
                "address", address
            );

            window.location.href = '{{ route('payment') }}';

        });
    </script>
@stop
