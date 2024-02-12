<div class="product-seller-info ui-box" style="background-color: #fff">
    <div class="seller-info-changeable">
        @if($product['seller'] !== '')
            <div class="product-seller-row seller">
                <div class="product-seller-row-icon marginTop10">
                    <i class="icon-visit-store colorYellow  productIcon"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="product-seller-row-detail-title">{{ $product['seller'] }}</div>
                </div>
            </div>
            <hr>
        @endif
        
        @if ($product['guarantee'] !== null)
            <div class="product-seller-row">
                <div class="product-seller-row-icon marginTop10">
                    <i class="icon-visit-verified colorYellow  productIcon"></i>
                </div>
                <div class="product-seller-row-detail">
                    <div class="product-seller-row-detail-title">گارانتی {{$product['guarantee']}} ماهه</div>
                </div>
            </div>
            <hr>
        @endif
        
        <div class="product-seller-row product-seller-row--clickable">
            <div class="product-seller-row-icon marginTop10">
                <i class="icon-visit-original colorYellow  productIcon"></i>
            </div>
            <div class="product-seller-row-detail">
                <div class="product-seller-row-detail-title">تضمین اصالت</div>                                        </div>
        </div>
        <hr>
        <div class="product-seller-row">
            <div class="product-seller-row-icon marginTop10">
                <i class="icon-visit-truck colorYellow  productIcon"></i>
            </div>
            <div class="product-seller-row-detail">
                <div class="product-seller-row-detail-title">
                    ارسال : <span class="fontNormal fontSize16"> 2 تا 7 روز کاری </span>
                </div>
            </div>
        </div>
        <hr>
        @if ($product['available_count'] != 0)
        <div class="product-seller-row product-seller-row--price pt-2 flexDirectionColumnR align-items-end">
            <div class="product-seller-row--price-now fa-num ">
                <span class="price">{{ $product['off'] != null ?  $product['priceAfterOff'] : $product['price'] }}</span>
                <span class="currency fontSize18 colorYellow">ت</span>
            </div>
            @if($product['off'] != null)
                <div class="product-price fa-num">
                    <div id="OffSection" class="d-flex align-items-center">
                        <div class="fontSize15 pl-10 position-relative">
                            <img src="{{ asset('theme-assets/images/svg/off.svg') }}" alt="" width="45">
                            <span id="Off" class="position-absolute fontSize10 colorWhite r-0 customOff">
                                @if ($product['off'] != null && $product['off']['type'] == 'percent')
                                    <span>%</span>{{ $product['off']['value'] }}
                                @elseif ($product['off']!= null && $product['off']['type'] == 'value') 
                                    {{ $product['off']['value'] }}
                                    {{-- <span class="fontSize10 px-1 colorYellow">ت</span> --}}
                                @endif
                            </span>
                        </div>
                        <del id="PriceBeforeOff" class="customlineText textColor fontSize15 PriceBeforeOff">{{ $product['price'] }}</del>
                    </div>
                </div>
            @endif
        </div>
        @endif

        @if ($product['available_count'] < 0)
            <div class="availableCount product-seller-row product-remaining-in-stock">
                <span></span>
            </div>
        @endif
        @if($product['available_count'] > 0)
            <div class="availableCount product-seller-row product-remaining-in-stock">
                <span>تنها <span class="mx-2">{{ $product['available_count'] }}</span> عدد در انبار باقیست - پیش از
                    اتمام بخرید</span>
            </div>
        @elseif($product['available_count'] == 0)
            <div class="availableCount product-seller-row product-remaining-in-stock">
                <span>اتمام موجودی</span>
            </div>
        @endif

        {{-- @if($product['available_count'] != 0) --}}
            <div class="show_if_available">
                <div class="product-seller-row product-remaining-in-stock spaceBetween">
                    <div class="bold textColor d-flex align-items-center ">
                        <div>تعداد سفارش :</div>                                            
                    </div>
                    <div class="num-block fa-num me-3">
                        <span class="num-in">
                            <span class="icon-visit-Exclusion1 countPlus customColorBlack d-flex justify-content-center align-items-center"></span>
                            <input name="counter" type="text" value="1" readonly="">
                            <span class="icon-visit-Exclusion2 countMinus customColorBlack d-flex justify-content-center align-items-center"></span>
                        </span>
                    </div>
                </div>

                <div class="product-seller--add-to-cart">
                    <a onclick="addToBasket()" class="btn btn-primary backgroundColorBlue w-100">
                        افزودن به سبد خرید
                    </a>
                </div>
            </div>
        {{-- @endif --}}
    </div>
<script>
    
    $(".countPlus").on('click', function() {

        let now = Date.now();

        if(now - lastChangeWantedCount < 50)
            return;

        lastChangeWantedCount = now;
        
        wantedCount++;
        $("input[name='counter']").each(function() {
            $(this).val(wantedCount);
        });
    });

    $(".countMinus").on('click', function() {
                
        let now = Date.now();

        if(now - lastChangeWantedCount < 50)
            return;

        lastChangeWantedCount = now;

        if(wantedCount == 1)
            return;

        wantedCount--;
        $("input[name='counter']").each(function() {
            $(this).val(wantedCount);
        });

    });

    function addToBasket() {
        
        if(finalAvailableCount !== -1 && wantedCount > finalAvailableCount) {
            showErr("تعداد انتخابی از تعداد موجودی بیشتر است!");
            return;
        }

        let basket = window.localStorage.getItem("basket");
        if(basket === null || basket === undefined)
            basket = [];
        else
            basket = JSON.parse(basket);

        let wantedProduct = '{{ $product['id'] }}';

        tmp = basket.find((elem, idx) => {
            return elem.product_id === wantedProduct && elem.color === wantedColor &&
                elem.detail.feature === wantedFeature;
        });

        if(tmp !== undefined) {
            tmp.count += wantedCount;
            basket = basket.map((elem, index) => {

                if(elem.id === tmp.id)
                    return tmp;

                return elem;
            });
        }
        else {
            basket.push({
                count: wantedCount,
                color: wantedColor,
                colorLabel: wantedColorLabel,
                id: Date.now() + "_" + wantedProduct,
                product_id: wantedProduct,
                detail: {
                    'title': '{{ $product['name'] }}',
                    'img': '{{ $product['img'] }}',
                    'alt': '{{ $product['alt'] }}',
                    'href': '{{ url()->current() }}',
                    // 'price': '{{ $product['price'] }}',
                    'price': finalPrice,
                    'seller': '{{ $product['seller'] }}',
                    'category': '{{ $product['category'] }}',
                    'feature': wantedFeature,
                    'brand': '{{ $product['brand'] }}',
                    'guarantee': '{{ isset($product['guarantee']) ? $product['guarantee'] : null }}',
                    'off_type': '{{ isset($product['off']) ? $product['off']['type'] : null }}',
                    'off_value': '{{ isset($product['off']) ? $product['off']['value'] : null }}',
                }
            });
        }

        window.localStorage.setItem("basket", JSON.stringify(basket));
        showSuccess('به سبد اضافه شد!');
        refreshBasket();
    }

</script>