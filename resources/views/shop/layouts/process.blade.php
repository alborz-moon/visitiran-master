<header class="page-mini-header mb-5">
    <div class="container">
        <div class="d-flex justify-content-center pt-3 pb-5">
            <div class="logo-container">
                <a href="#" class="logo"><img src="./theme-assets/images/logo-dark.svg" width="150" alt=""></a>
            </div>
        </div>
        <ul class="checkout-steps customSteps">
            <li id="chooseBuy" class="checkout-step-active">
                <a href="#"><span class="checkout-step-title" data-title="تکمیل فرایند خرید"></span></a>
            </li>
            <li class="{{ $step == 'shipping' || $step == 'payment' ? 'checkout-step-active ' : '' }}">
                <a href="#"><span class="{{ $step == 'shipping' ? 'checkout-step-title' : '' }}" data-title="اطلاعات ارسال"></span></a>
            </li>
            <li class="{{ $step == 'payment' ? 'checkout-step-active' : '' }}">
                <a href="#"><span class="{{ $step == 'payment' ? 'checkout-step-title ' : '' }}" data-title="پرداخت"></span></a>
            </li>
        </ul>
    </div>
</header>