@extends('layouts.structure')
@section('content')
    <div class="container">
        <main class="page-content">
            <div class="container">

                <div id="empty-basket" class="row hidden">
                    <div class="col-12">
                        <!-- start of nav-tabs -->
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link fs-6 fw-bold active" id="nav-1-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1"
                                    aria-selected="true">
                                    سبد خرید
                                </button>
                                <button class="nav-link fs-6 fw-bold" id="nav-2-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-2"
                                    aria-selected="false">
                                    لیست خرید بعدی
                                </button>
                            </div>
                        </nav>
                        <!-- end of nav-tabs -->
                        <!-- start of tab-content -->
                        <div class="tab-content" id="nav-tabContent">
                            <!-- start of tab-pane -->
                            <div class="tab-pane py-4 fade show active" id="nav-1" role="tabpanel"
                                aria-labelledby="nav-1-tab">
                                <div class="ui-box bg-white">
                                    <div class="ui-box-empty-content">
                                        <div class="ui-box-empty-content-icon">
                                            <img src="./theme-assets/images/theme/cart-empty.png" alt="">
                                        </div>
                                        <div class="ui-box-empty-content-message text-center">
                                            <div class="mb-3">سبد خرید شما خالی است!</div>
                                            <p class="text-secondary text-decoration-none fs-7 fw-bold">
                                                می‌توانید برای مشاهده محصولات بیشتر به صفحات زیر بروید
                                            </p>
                                            <div class="d-flex justify-content-center flex-wrap">
                                                <a href="#" class="link fs-7 fw-bold border-bottom-0 m-2">تخفیف‌ها و
                                                    پیشنهادها</a>
                                                <a href="#" class="link fs-7 fw-bold border-bottom-0 m-2">محصولات
                                                    پرفروش
                                                    روز</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of tab-pane -->
                            <!-- start of tab-pane -->
                            <div class="tab-pane py-4 fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                <div class="ui-box bg-white">
                                    <div class="ui-box-empty-content">
                                        <div class="ui-box-empty-content-icon">
                                            <img src="./theme-assets/images/theme/cart-empty-sfl.png" alt="">
                                        </div>
                                        <div class="ui-box-empty-content-message text-center">
                                            <div class="mb-3">لیست خرید بعدی شما خالی است!</div>
                                            <div class="col-8 mx-auto">
                                                <p class="text-secondary text-decoration-none fs-7 fw-bold">
                                                    شما می‌توانید محصولاتی که به سبد خرید خود افزوده‌اید و فعلا قصد خرید
                                                    آن‌ها را ندارید، در لیست خرید بعدی قرار داده و هر زمان مایل بودید
                                                    آن‌ها
                                                    را به سبد خرید اضافه کرده و خرید آن‌ها را تکمیل کنید.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of tab-pane -->
                        </div>
                        <!-- end of tab-content -->
                    </div>
                </div>

                <div id="full-basket" class="row">
                    <div class="col-xl-9 col-lg-8">
                        @include('shop.layouts.process', ['step' => 'basket'])

                        <div class="hidden" id="sample_full_basket_item">
                            @include('shop.cart.items_cart')
                        </div>

                        <div id="full_basket_items"></div>

                    </div>
                    @include('shop.cart.basket_cart', ['nextBtnId' => 'goToShipingBtn'])

                </div>
            </div>
        </main>
    @stop

    @section('footer')
        @parent
    @stop

    @section('extraJS')
        @parent
        <script>
            $(document).ready(function() {

                let products = [];

                let basket = window.localStorage.getItem("basket");
                basket = JSON.parse(basket);

                for (let i = 0; i < basket.length; i++) {
                    let data = {
                        count: basket[i].count,
                        id: basket[i].product_id,
                    };

                    if (basket[i].colorLabel !== undefined)
                        data.feature = basket[i].colorLabel;
                    else if (basket[i].detail.feature !== undefined)
                        data.feature = basket[i].detail.feature;

                    products.push(data);
                }

                $.ajax({
                    type: 'post',
                    url: '{{ route('api.refresh_basket') }}',
                    data: {
                        'products': products
                    },
                    success: function(res) {

                        let new_basket = [];

                        if (res.orders.length != basket.length) {
                            showErr('خطایی در به روزرسانی سبدخرید شما به وجود آمده است');
                            return;
                        }

                        for (let i = 0; i < res.orders.length; i++) {
                            new_basket.push({
                                count: res.orders[i].available >= res.orders[i].wanted ? res.orders[
                                    i].wanted : res.orders[i].available,
                                color: basket[i].color,
                                colorLabel: basket[i].colorLabel,
                                id: basket[i].id,
                                product_id: res.orders[i].id,
                                detail: {
                                    'title': res.orders[i].name,
                                    'img': basket[i].detail.img,
                                    'alt': basket[i].detail.alt,
                                    'href': basket[i].detail.href,
                                    'price': res.orders[i].unit_price,
                                    'seller': basket[i].detail.seller,
                                    'category': basket[i].detail.category,
                                    'feature': basket[i].detail.feature,
                                    'brand': basket[i].detail.brand,
                                    'guarantee': basket[i].detail.guarantee,
                                    'off_type': res.orders[i].off != null && res.orders[i]
                                        .off_amount > 0 ? res.orders[i].off.type : null,
                                    'off_value': res.orders[i].off != null && res.orders[i]
                                        .off_amount > 0 ? res.orders[i].off
                                        .value : null,
                                }
                            });
                        }

                        window.localStorage.setItem("basket", JSON.stringify(new_basket));
                        renderBasket();
                    }
                });

                $("#goToShipingBtn").on('click', function() {
                    @if (Auth::check())

                        let products = [];

                        let basket = window.localStorage.getItem("basket");
                        basket = JSON.parse(basket);

                        for (let i = 0; i < basket.length; i++) {
                            let data = {
                                count: basket[i].count,
                                id: basket[i].product_id,
                            };

                            if (basket[i].colorLabel !== undefined)
                                data.feature = basket[i].colorLabel;
                            else if (basket[i].detail.feature !== undefined)
                                data.feature = basket[i].detail.feature;

                            products.push(data);
                        }

                        $.ajax({
                            type: 'post',
                            url: '{{ route('api.check_basket') }}',
                            data: {
                                products: products
                            },
                            success: function(res) {
                                if (res.status === "ok")
                                    document.location.href = '{{ route('shipping') }}';
                                else {
                                    showErr("ارور");
                                }
                            }
                        });
                    @else
                        localStorage.setItem("url", '{{ URL::current() }}');
                        document.location.href = '{{ route('login-register') }}';
                    @endif
                })
            })
        </script>
    @stop
