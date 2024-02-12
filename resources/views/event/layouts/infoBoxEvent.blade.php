<!-- start of product-seller-info -->
<div class="product-seller-info ui-box p-0">
    <div class="seller-info-changeable">
        @if ($event['address'] != null)
            <div class="product-seller-row p-0">
                <div class="product-seller-row-icon marginTop9">
                    <!-- <i class="ri-store-3-fill"></i> -->
                    <i class="icon-visit-location colorYellow"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="seller-final-score-container p-2">
                        <div class="seller-rate-container">
                            <span class="fontSize14 fontWight400 colorBlack">
                                {{ $event['address'] }}
                            </span>
                        </div>
                    </div>
                    <a href="#" class="seller-info-link"></a>
                </div>
            </div>
        @endif
        @if (isset($x))
            <div class="d-flex alignItemsCenter spaceBetween gap10 p-1">
                <button data-remodal-target="modal-map"
                    class="buttonBasketEvent whiteSpaceNoWrap btnEventHover mapModalBtn">
                    <span class="colorWhiteGray fontSize14 fontWight400 px-1">مشاهده رو نقشه</span>
                    <i class="icon-visit-eye colorWhiteGray verticalAlign-2 px-1"></i>
                </button>
                <button class="buttonBasketEvent whiteSpaceNoWrap btnEventHover">
                    <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination={{ $x . ',' . $y }}"
                        class="colorWhiteGray fontSize14 fontWight400 px-1">مسیر یابی</a>
                    <i class="icon-visit-location colorWhiteGray verticalAlign-2 px-1"></i>
                </button>
            </div>
        @endif
        <hr>
        @if ($event['phone'] != null)
            <div class="product-seller-row p-0">
                <div class="product-seller-row-icon marginTop9">
                    <i class="icon-visit-phone colorYellow"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="seller-final-score-container p-2">
                        <div class="seller-rate-container">
                            <?php $i = 0; ?>
                            @foreach ($event['phone'] as $phone)
                                <a href="tel:{{ $phone }}"
                                    class="colorBlack fontSize14 fontWight400">{{ $phone }}
                                    @if ($i < count($event['phone']) - 1)
                                        <span class="mx-1">-</span>
                                    @endif
                                </a>
                                <?php $i++; ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        @if ($event['email'] != null)
            <div class="product-seller-row p-0">
                <div class="product-seller-row-icon marginTop9">
                    <i class="icon-visit-mail colorYellow"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="seller-final-score-container">
                        <div class="seller-rate-container ">
                            <a href="mailto:{{ $event['email'] }}"
                                class="colorBlack fontSize14 fontWight400 d-flex justify-content-end">
                                {{ $event['email'] }}
                            </a>
                        </div>
                    </div>
                    <a href="#" class="seller-info-link"></a>
                </div>
            </div>
        @endif
        @if ($event['site'] != null)
            <hr>
            <div class="product-seller-row p-0">
                <div class="product-seller-row-icon marginTop9">
                    <i class="icon-visit-website colorYellow"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="seller-final-score-container">
                        <div class="seller-rate-container ">
                            <a href="{{ $event['site'] }}"
                                class="ltr h-20 overFlowHidden colorBlack fontSize14 fontWight400 d-flex justify-content-start">
                                {{ $event['site'] }}
                            </a>
                        </div>
                    </div>
                    <a href="#" class="seller-info-link"></a>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- end of product-seller-info -->
<!-- start of modal-show-map -->
<div class="remodal remodal-xl" data-remodal-id="modal-map" data-remodal-options="hashTracking: false">
    <div class="remodal-header">
        <div class="remodal-title">مشاهده نقشه</div>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div>
    <div class="remodal-content">
        <div class="form-element-row mb-3">
            <div id="launchermap" style="height: 75vh">

            </div>
        </div>
    </div>
    <div class="remodal-footer">
        <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
    </div>
</div>
<!-- end of modal-show-map -->
