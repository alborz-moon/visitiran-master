
<!-- start of tab-content -->
<div class="tab-content" id="nav-tabContent">
    <!-- start of tab-pane -->
    <div class="tab-pane fade show active" id="nav-1" role="tabpanel"
        aria-labelledby="nav-1-tab">
        <div class="ui-box bg-white borderEa p-2 position-relative">
            <span id="full-basket-item-category" class="colorWhite customCartLabel fontSize11 position-absolute r-0 zIndex1" style="top: 15px"></span>
            <div class="ui-box-content ">
                <!-- start of cart-items -->
                <div class="cart-items position-relative">
                    <!-- start of cart-item -->
                    <div class="cart-item">
                        <div class="cart-item--thumbnail">
                            <a class="position-relative" href="#">
                                <img id="full-basket-item-img">
                            </a>
                        </div>
                        <div class="cart-item--detail">
                            <h2 class="cart-item--title mb-2"><a id="full-basket-item-href" href="#"></a></h2>
                            {{-- style="margin-right: 50px" --}}
                            <div id="full-basket-item-feature-parent" class="cart-item--variant mb-2 hidden">
                                <span id="full-basket-item-feature" class="ms-1 hidden"></span>
                            </div>
                            <div id="full-basket-item-color-parent" class="cart-item--variant mb-2 hidden">
                                <span id="full-basket-item-color" class="color hidden"></span>
                                <span id="full-basket-item-color-label" class="ms-1 hidden"></span>
                            </div>
                            <div class="cart-item--data mb-1">
                                <ul>
                                    <li id="full-basket-item-seller-parent" class="hidden">
                                        <i class="icon-visit-store colorYellow d-flex productIcon"></i><span id="full-basket-item-seller" class="colorBlack fontSize13"> seller</span>
                                    </li>
                                    <li id="full-basket-item-guarantee-parent" class="hidden">
                                        <i class="icon-visit-verified colorYellow d-flex productIcon"></i><span class="colorBlack fontSize13 px-1">دارای</span><span id="full-basket-item-guarantee" class="colorBlack fontSize13"> 18</span><span class="colorBlack fontSize13 px-1">ماه گارانتی</span>
                                    </li>
                                    <li>
                                        <i class="icon-visit-original colorYellow d-flex productIcon"></i><span class="colorBlack fontSize13">تضمین اصالت</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="cart-item--price--actions">
                                <div class="cart-item--actions">
                                    <div class="product-seller-row product-remaining-in-stock spaceBetween">
                                        <div class="bold customColorBlack d-flex align-items-center ">
                                            <div>تعداد سفارش :</div>                                            
                                        </div>
                                        <div class="num-block fa-num me-3">
                                            <span class="num-in">
                                                <span id="full-basket-item-plus-btn" class="icon-visit-Exclusion1 countPlus customColorBlack d-flex justify-content-center align-items-center"></span>
                                                <input id="full-basket-item-count" name="counter" type="text" value="1" readonly="">
                                                <span id="full-basket-item-minus-btn" class="icon-visit-Exclusion2 countMinus customColorBlack d-flex justify-content-center align-items-center"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <button id="full-basket-item-remove-btn" class="removeBasketItemBtn btn btn-link btn-sm text-secondary position-absolute t-0 l-0"><i
                                            class="icon-visit-delete colorRed me-1 mt-2"></i><span class="colorRed">حذف</span></button>
                                </div>
                                <div class="product-seller-row product-seller-row--price pt-2">
                                    <div class="product-price fa-num">
                                        <div id="full-basket-item-off-section" class="d-flex align-items-center hidden">
                                            <div class="fontSize15 pl-10 position-relative">
                                                <img src="{{ asset('theme-assets/images/svg/off.svg') }}" alt="" width="45">
                                                <span class="position-absolute fontSize10 colorWhite r-0 customOff">
                                                        <span id="full-basket-item-off-amount">%</span>
                                                </span>
                                            </div>
                                            <del id="full-basket-item-price-before-off" class="customlineText textColor fontSize21 bold"></del>
                                        </div>
                                    </div>
                                    <div class="product-seller-row--price-now fa-num d-flex justifyContentEnd ">
                                        <span id="full-basket-item-price" class="price fontSize21 bold"></span>
                                        <span class="currency fontSize21 bold colorYellow">ت</span>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of cart-item -->
                </div>
                <!-- end of cart-items -->
            </div>
        </div>
    </div>
</div>
