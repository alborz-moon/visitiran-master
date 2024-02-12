<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="ui-sticky ui-sticky-top">
        <!-- start of checkout-bill -->
        <div class="checkout-bill ui-box bg-white mb-5">
            <div class="checkout-bill-row py-20">
                <div class="checkout-bill-row-label fontSize15 bold colorText">تعداد کل کالا</div>
                <div class="checkout-bill-row-value fontSize15 bold colorText"><span id="full_basket_count_items" class="fs-6"></span> 
                </div>
            </div>
            <hr>
            <div class="checkout-bill-row py-20">
                <div class="checkout-bill-row-label fontSize15 bold colorText">مجموع قیمت</div>
                <div class="checkout-bill-row-value fontSize15 bold colorText"><span id="full_basket_total_price" class="fs-6 text-danger"></span>
                    <span class="currency text-danger fontSize15 bold colorYellow">ت</span></div>
            </div>
            <hr>
            <div class="checkout-bill-row py-20">
                <div class="checkout-bill-row-label fontSize15 bold colorRed">مجموع تخفیف</div>
                <div class="checkout-bill-row-value fontSize15 bold colorRed"><span id="full_basket_total_off" class="fs-6"></span> <span
                        class="currency fontSize15 bold colorYellow">ت</span>
                </div>
            </div>
            <hr>
            <div class="checkout-bill-row py-20">
                <div class="checkout-bill-row-label fontSize15 bold colorText">قیمت کل</div>
                <div class="checkout-bill-row-value fontSize15 bold colorText"><span id="full_basket_total_after_price" class="fs-6"></span> <span
                        class="currency fontSize15 bold colorYellow">ت</span>
                </div>
            </div>
            <hr>
            <div class="checkout-bill-row checkout-bill-note fontSize12 fontNormal">
                هزینه‌ی ارسال در ادامه بر اساس آدرس، زمان و نحوه‌ی ارسال انتخابی شما‌ محاسبه و به
                این مبلغ اضافه خواهد شد
            </div>
            <div class="checkout-bill-row checkout-bill-action">
                @if(Auth::check())
                    <a id="{{ $nextBtnId }}" class="btn btn-block btn-primary">ادامه فرایند خرید</a>
                @else
                    <a id="{{ $nextBtnId }}" class="btn btn-block btn-primary">ورود به سایت برای ادامه خرید</a>
                @endif
            </div>
        </div>
        <!-- end of checkout-bill -->
    </div>
</div>