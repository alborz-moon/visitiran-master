<div class="product-card customEventBorderBox">
    <div class="product-thumbnail mx-n15">
        <a>
            <img class="objectFitCover imgCardEvent" id="{{ $key }}Img">
        </a>
    </div>
    <div class="product-card-body">
        <h2 class="product-title">
            <a id="{{ $key }}Header" class="textColor fontSize14 bold"></a>
        </h2>
        <h2 id="{{ $key }}StartContainer" class="product-title hidden">
            <span class="fontSize14">شروع</span>
            <a id="{{ $key }}Header2" class="textColor fontSize14"></a>
        </h2>
        <div class="product-variant">
            <span id="{{ $key }}Tag" class="colorWhite customBoxLabel fontSize11"></span>
        </div>
        <div id="{{ $key }}MultiColor" class="colorCircle hidden"></div>
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
        <div id="{{ $key }}LauncherParent" class="textColor hidden">
            <span class="bold">مکان </span>
            <span id="{{ $key }}Launcher"></span>
        </div>
        <div id="{{ $key }}LauncherParent2" class="textColor hidden">
            <span class="bold">برگزار کننده</span>
            <span id="{{ $key }}Launcher2"></span>
        </div>
    </div>
</div>