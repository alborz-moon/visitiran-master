@extends('layouts.structure')
@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-6 mb-lg-0 mb-4">
                    @include('shop.layouts.process', ['step' => 'payment'])
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <!-- start of box => payment-methods -->
                            <div class="ui-box bg-white payment-methods mb-5">
                                <div class="ui-box-title">شیوه پرداخت</div>
                                <div class="ui-box-content">
                                    <!-- start of custom-radio-outline -->
                                    <div class="custom-radio-outline">
                                        <input type="radio" class="custom-radio-outline-input" name="checkoutPayment"
                                            id="checkoutPayment01">
                                        <label for="checkoutPayment01" class="custom-radio-outline-label">
                                            <span class="label">
                                                <span class="icon"><i class="ri-secure-payment-fill"></i></span>
                                                <span class="detail">
                                                    <span class="title">پرداخت اینترنتی</span>
                                                    <span class="subtitle">آنلاین با تمامی کارت‌های بانکی</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <!-- end of custom-radio-outline -->
                                    <!-- start of custom-radio-outline -->
                                    <div class="custom-radio-outline">
                                        <input type="radio" class="custom-radio-outline-input" name="checkoutPayment"
                                            id="checkoutPayment02">
                                        <label for="checkoutPayment02" class="custom-radio-outline-label">
                                            <span class="label">
                                                <span class="icon"><i class="ri-wallet-3-fill"></i></span>
                                                <span class="detail">
                                                    <span class="title">پرداخت از طریق کیف پول</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <!-- end of custom-radio-outline -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="ui-box bg-white payment-methods mb-5">
                                <div class="ui-box-title"> افزودن کد تخفیف </div>
                                <div class="ui-box-content p-5">
                                    <div class="coupon">
                                        <div class="form-element-row with-btn">
                                            <input id="off" type="text" class="form-control"
                                                placeholder="افزودن کد تخفیف">
                                            <button onclick="checkOff()" class="btn btn-primary">ثبت</button>
                                        </div>

                                        <div id="off_result"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of box => payment-methods -->
                    <a href='{{ route('shipping') }}' class="link border-bottom-0"><i class="ri-arrow-right-s-fill"></i>
                        بازگشت به شیوه ی
                        ارسال</a>
                </div>
                @include('shop.cart.basket_cart', ['nextBtnId' => 'goToPaymentBtn'])
            </div>
        </div>
    </main>
@stop

@section('extraJS')
    @parent

    <script src="{{ asset('theme-assets/js/basket.js') }}"></script>

    <script>
        $(document).ready(function() {
            renderPaymentCard();
        });

        function checkOff() {

            let code = $("#off").val();
            let total = parseInt($("#full_basket_total_after_price").text().replaceAll(",", ""));

            $.ajax({
                type: 'post',
                url: '{{ route('checkoff') }}',
                data: {
                    code: code,
                    amount: total
                },
                success: function(res) {

                    let resultClass = res.status === 'ok' ? 'colorGreen' : 'colorRed';
                    $("#off_result").empty().append(res.msg)
                        .removeClass('colorGreen').removeClass('colorRed')
                        .addClass(resultClass);

                    if (res.status === 'ok') {
                        let total_before_price = parseInt($("#full_basket_total_price").text().replaceAll(",",
                            ""));
                        $("#full_basket_total_after_price").empty().append(res.new_amount);
                        let old_off_amount = parseInt($("#full_basket_total_off").text().replaceAll(",", ""));
                        old_off_amount = Math.min(res.off_amount + old_off_amount, total_before_price);
                        $("#full_basket_total_off").empty().append(old_off_amount.formatPrice(0, ",", ""));
                    }

                }
            });

        }

        $(document).on('click', '#goToPaymentBtn', function() {

            let address = window.localStorage.getItem("address");
            if (address === undefined) {
                showErr('لطفا به مرحله قبل بازگردید و آدرس موردنظر خود را وارد نمایید');
                return;
            }

            let time = window.localStorage.getItem("time");
            if (time === undefined) {
                showErr('لطفا به مرحله قبل بازگردید و زمان ارسال موردنظر خود را وارد نمایید');
                return;
            }

            let products = [];
            let basket = window.localStorage.getItem("basket");

            if (basket === undefined || basket === null) {
                showErr('خطایی در پردازش سبدخرید شما به وجود آمده است');
                return;
            }

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

            let code = $("#off").val();
            let data = {
                'products': products,
                'address_id': address,
                'time': time
            };

            if (code !== undefined && code.length > 0)
                data['off'] = code;

            $.ajax({
                type: 'post',
                url: '{{ route('api.finalize_basket') }}',
                data: data,
                success: function(res) {

                    if (res.status === 'ok') {
                        if (res.action === 'registered') {
                            showSuccess('خرید شما با موفقیت انجام شد');
                            window.localStorage.removeItem('basket');
                            setTimeout(() => {
                                window.location.href = '{{ route('profile.my-orders') }}';
                            }, 1000);
                        }
                    }

                }
            });

        });
    </script>

@stop
