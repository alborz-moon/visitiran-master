<!-- start of product-card -->
    <div class="product-card customBorderBoxShadow" style="{{ isset($autoHeight) && $autoHeight ? 'height: auto;' : '' }}">
        <div class="product-thumbnail">
            <a>
                <img id="{{ $key }}Img">
            </a>
        </div>
        <div class="product-card-body">
            <h2 class="product-title">
                <a id="{{ $key }}Header" class="textColor fontSize12"></a>
            </h2>
            <div class="product-variant">
                <span id="{{ $key }}Tag" class="colorWhite customBoxLabel fontSize11 hidden"></span>
            </div>
            <div id="{{ $key }}MultiColor" class="colorCircle hidden"></div>
            <div class="spaceBetween mt-3 mb-3">
                <span id="{{ $key }}Critical" class="fontSize11 invisible colorRed whiteSpaceNoWrap">
                    <span id="{{ $key }}AvailableJust" class="hidden">
                        <span>موجودی تنها</span>
                        <span>&nbsp;</span>
                        <span id="{{ $key }}CriticalCount"></span>
                        <span>&nbsp;</span>
                        <span>عدد</span>
                    </span>
                    <span id="{{ $key }}FinishAvailable" class="hidden">اتمام موجودی</span>
                </span>
                <span id="{{ $key }}Rate"></span>
            </div>
            <div class="product-price fa-num">
                <div id="{{ $key }}OffSection" class="hidden d-flex align-items-center">
                    <span class="fontSize15 pl-10 position-relative">
                        <img src="{{ asset('theme-assets/images/svg/off.svg') }}" alt="">
                        <span id="{{ $key }}Off" class="position-absolute fontSize10 colorWhite r-0 customOff">20%</span>
                    </span>
                    <del id="{{ $key }}PriceBeforeOff" class="customlineText textColor fontSize15">26,900,000</del>
                </div>
                <div id="{{ $key }}PriceParent" class="fontSize20 hidden">
                    <span id="{{ $key }}Price"></span>
                    <span class="fontSize20 colorYellow">ت</span>
                </div>
            </div>
        </div>
        <div class="product-card-footer mb-2">
            <div id="{{ $key }}SellerParent" class="textColor hidden">
                <span class="bold">از</span>
                <span id="{{ $key }}Seller"></span>
            </div>
        </div>
    </div>
    <!-- end of product-card -->