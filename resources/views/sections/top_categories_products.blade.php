<div id="top_categories_products_sliders">
    <!-- start of box -->
    <div id="sampleSlider" class="w-100 my-slider mb-5 hidden">
        <div class="container">
            <div class="d-flex spaceBetween alignItemsCenter">
                <span class="ui-box-title fontSize20"> 
                    <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">
                    <span id="sampleSliderTitle"></span>
                </span>
                <span class="alignItemsCenter colorBlue"><a class="hoverBold" href="{{ isset($href) ? $href : '' }}">مشاهده همه</a></span>
            </div>
            <div class="ui-box-content">
                <!-- Slider main container -->
                <div class="swiper product-swiper-slider">
                    <!-- Additional required wrapper -->
                    <div id="topCategoryProductsSlider" class="swiper-wrapper">
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of box -->

</div>

<!-- Slides -->
<div id="topCategoryProductsSample" class="cursorPointer hidden">
    <div class="swiper-slide customBox customWidthBox">
        <!-- start of product-card -->
        <div class="product-card customBorderBoxShadow">
            <div class="product-thumbnail">
                <a>
                    <img id="topCategoryProductImg">
                </a>
            </div>
            <div class="product-card-body">
                <h2 class="product-title">
                    <a id="topCategoryProductHeader" class="textColor fontSize12"></a>
                </h2>
                <div class="product-variant">
                    <span id="topCategoryProductTag" class="colorWhite customBoxLabel fontSize11"></span>
                </div>
                <div id="topCategoryProductMultiColor" class="colorCircle hidden"></div>
                <div class="spaceBetween mt-3 mb-3">
                    <span id="topCategoryProductCritical" class="fontSize11 invisible colorRed whiteSpaceNoWrap">
                        <span>موجودی تنها</span>
                        <span>&nbsp;</span>
                        <span id="topCategoryProductCriticalCount"></span>
                        <span>&nbsp;</span>
                        <span>عدد</span>
                    </span>
                    <span id="topCategoryProductRate"></span>
                </div>
                <div class="product-price fa-num">
                    <div id="topCategoryProductOffSection" class="hidden d-flex align-items-center">
                        <span class="fontSize15 pl-10 position-relative">
                            <img src="{{ asset('theme-assets/images/svg/off.svg') }}" alt="">
                            <span id="topCategoryProductOff" class="position-absolute fontSize10 colorWhite r-0 customOff">20%</span>
                        </span>
                        <del id="topCategoryProductPriceBeforeOff" class="customlineText textColor fontSize15">26,900,000</del>
                    </div>
                    <div id="topCategoryProductPriceParent" class="hidden fontSize20">
                        <span id="topCategoryProductPrice">26,249,000</span>
                         <span class="fontSize20 colorYellow">ت</span>
                    </div>
                </div>
            </div>
            <div class="product-card-footer mb-2">
                <div class="textColor">
                    <span id="topCategoryProductSellerParent" class="bold hidden">از</span>
                    <span id="topCategoryProductSeller"></span>
                </div>
            </div>
        </div>
        <!-- end of product-card -->
    </div>
</div>

<script>

    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '{{ route('api.get_top_categories_products') }}',
            success: function(res) {
                let html = "";
                res.data.forEach((elem) => {

                    $("#sampleSliderTitle").text(elem.name);

                    let id = elem.id;
                    let prefix = "topCategoryProduct";

                    let innerHtml = renderProductSlider(elem.products, prefix);
                    
                    $("#topCategoryProductsSlider").empty().append(innerHtml);

                    var newElem = $("#sampleSlider").html();
                    newElem = newElem.replace("sampleSlider", "cat_" + id + "_sampleSlider")
                        .replace('id="topCategoryProductsSlider"', 'id="cat_' + id + '_topCategoryProductsSlider"');

                    html += '<div class="w-100 mb-5">' + newElem + '</div>';
                    
                });
                $("#top_categories_products_sliders").empty().append(html);

                const productSpecialsSwiperSlider = new Swiper(
                    ".product-swiper-slider",
                    {
                        // Optional parameters
                        spaceBetween: 10,

                        // Navigation arrows
                        navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                        },

                        breakpoints: {
                        1200: {
                            slidesPerView: 5,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                        576: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 8,
                        },
                        },
                    }
                );
            }
        });
    });

</script>