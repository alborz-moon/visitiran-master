@extends('layouts.structure')

@section('seo')
    <title>بازارگاه صنایع دستی | {{ $product['name'] }}</title>
    <meta property="og:title" content="{{ $product['name'] }}" />
    <meta name="twitter:title" content="{{ $product['name'] }}" />
    <meta property="og:site_name" content="{{ $product['name'] }}" />
    <meta property="og:image" content="{{ $product['img'] }}" />
    <meta property="og:image:secure_url" content="{{ $product['img'] }}" />
    <meta name="twitter:image" content="{{ $product['img'] }}" />
    <meta property="og:description" content="{{ $product['digest'] }}" />
    <meta name="twitter:description" content="{{ $product['digest'] }}" />
    <meta name="description" content="{{ $product['digest'] }}" />
    <meta name="keywords" content="{{ $product['keywords'] }}" />
    {{-- <meta property="article:tag" content="{{ $product['tags'] }}"/> --}}

    <script>
        let productPrefixRoute = '{{ route('home') }}' + "/product";
        let finalAvailableCount = parseInt('{{ $product['available_count'] }}');
        let wantedCount = 1;
        let lastChangeWantedCount = -1;
        let wantedColor = undefined;
        let wantedColorLabel = undefined;
        let wantedFeature = undefined;
        let finalPrice = '{{ $product['price'] }}';
    </script>

@stop

@section('content')
    <div class="container">
        <main class="page-content TopParentBannerMoveOnTop">
            <div class="container">
                <!-- start of product-detail-container -->
                <!-- start of breadcrumb -->
                <div class="product-detail-container mb-3">
                    @include('layouts.breadcrumb', ['product' => $product])
                    <!-- end of breadcrumb -->
                    <div class="row mb-5">
                        <div class="col-lg-4 col-md-5 mb-md-0 mb-4">
                            <div class="ui-sticky ui-sticky-top">
                                <!-- start of product-gallery -->
                                <div class="product-gallery">
                                    <div class="gallery-img-container">
                                        <div class="gallery-img m-0 p-0" id="galleryMain">
                                            <img class="zoom-img b-0" src="{{ $product['img'] }}"
                                                alt="{{ $product['alt'] }}" />
                                        </div>
                                        <div class="gallery-thumbs overFlowHidden">
                                            <ul id="gallery" style="justify-content: right !important;">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of product-gallery -->
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-7 mb-lg-0 mb-4">
                            <!-- start of product-detail -->
                            <h2 id="productTitle" class="product-title">{{ $product['name'] }}</h2>
                            <div class="product-user-meta fa-num mb-4 spaceBetween">
                                <span class="product-users-rating">
                                    <span class="rattingToStar"></span>
                                    <span class="fw-bold me-1 fontSize22 colorYellow">{{ $product['rate'] }}</span>
                                    <span class="text-muted fs-7">(از <span>{{ $product['all_rates_count'] }}</span>
                                        رای)</span>
                                </span>
                                <a href="#" class="link border-bottom-0 fs-7 me-1 text-muted"> دیدگاه کاربران <span
                                        class="mr-1">({{ $product['all_comments_count'] }})</span></a>
                            </div>
                            @if ($product['seller'] !== '')
                                <div
                                    class="product-variant-selected-label bold mb-3 seller d-flex justify-content-center align-items-center pl-2 fontSize18">
                                    سازنده <div class="line mr-15"></div>
                                </div>
                                <div class="mb-3 fontSize16">{{ $product['seller'] }}</div>
                            @endif
                            <div id="color-div" class="product-variants-container mb-3 hidden">
                                <div class="product-variant-selected-container spaceBetween">
                                    <div
                                        class="product-variant-selected-label bold mb-3 seller d-flex justify-content-center align-items-center pl-2 fontSize18">
                                        رنگ</div>
                                    <div class="line mr-15 ml-15"></div>
                                    <div id="product-color-variant-selected" class="product-variant-selected"></div>
                                </div>
                                <div id="product-colors-variants" class="product-variants">
                                </div>
                            </div>

                            <div id="dynamic_multi_choice_features">

                            </div>

                            <div class="expandable-text mb-3" style="height: 200px;">
                                <div class="expandable-text_text">
                                    <div class="product-params">
                                        <div
                                            class="product-variant-selected-label bold mb-3 seller d-flex justify-content-center align-items-center pl-2 fontSize18 whiteSpaceNoWrap">
                                            ویژگی ها
                                            <div class="line mr-15"></div>
                                        </div>

                                        <ul id="properties">
                                        </ul>
                                    </div>

                                </div>
                                <div class="mb-3 mt-3">
                                    <div
                                        class="product-variant-selected-label bold mb-3 seller d-flex justify-content-center align-items-center pl-2 fontSize18">
                                        توضیحات
                                        <div class="line mr-15"></div>
                                    </div>
                                </div>
                                <div class="product-additional-info-container mb-3">
                                    <div class="product-additional-info">
                                        <p>{{ $product['description'] }}</p>
                                    </div>
                                </div>
                                <div class="expandable-text-expand-btn d-flex justify-content-end">
                                    <span class="show-more">
                                        بیشتر <i class="ri-arrow-down-s-line"></i>
                                    </span>
                                    <span class="show-less d-none">
                                        بستن <i class="ri-arrow-up-s-line"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- end of product-detail -->
                        </div>
                        <div class="col-xl-3 col-lg-4">
                            <!-- start of product-seller-info -->
                            @include('shop.product.product_basket_card', ['product' => $product])
                            <!-- end of product-seller-info -->
                        </div>
                    </div>
                </div>
                @include('sections.top_products_slider', [
                    'id' => 'most_seen_products_when_filled',
                    'api' => route('api.product.similars', ['product' => $product['id']]),
                    'key' => 'mostSeenProduct',
                    'disableShowAll' => true,
                    'title' => 'محصولات مشابه',
                    'not_fill_id' => 'most_seen_products_when_not_filled',
                ])

                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="ui-sticky ui-sticky-top mb-4 StickyMenuMoveOnTop">
                            <!-- start of product-tabs -->
                            <div class="product-tabs overFlowHidden">
                                <ul class="nav nav-pills">
                                    <li id="checkNavLink" class="nav-item">
                                        <a id="nav1" class="nav-link .my-nav-link active" href="#scrollspyHeading1"
                                            data-scroll="scrollspyHeading1">نقد و بررسی </a>
                                    </li>
                                    <li id="propertyNavLink" class="nav-item">
                                        <a id="nav2" class="nav-link .my-nav-link" href="#scrollspyHeading3"
                                            data-scroll="scrollspyHeading3">مشخصات</a>
                                    </li>
                                    <li id="commentNavLink" class="nav-item">
                                        <a id="nav3" class="nav-link .my-nav-link" href="#scrollspyHeading4"
                                            data-scroll="scrollspyHeading4">دیدگاه کاربران</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- end of product-tabs -->
                        </div>
                        <!-- start of product-content-expert-summary -->
                        <div class="details product-tab-content product-content-expert-summary tab-content  pb-2 mb-4"
                            id="scrollspyHeading1">
                            <div class="product-tab-title">
                                <div class="fontSize18 bold ">نقد و بررسی {{ $product['name'] }}</div>
                            </div>
                            <div class="pt-1" id="intro-container-parent">

                                <div id="intro-container" class="expandable-text_text">
                                    {!! $product['introduce'] !!}
                                </div>
                                <div id="show-more-container-for-intro"
                                    class="expandable-text-expand-btn justify-content-start text-sm d-flex justify-content-end hidden">
                                    <span class="show-more active">
                                        ادامه مطلب <i class="ri-arrow-down-s-line ms-2"></i>
                                    </span>
                                    <span class="show-less d-none">
                                        مشاهده کمتر <i class="ri-arrow-up-s-line ms-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end of product-content-expert-summary -->
                        <!-- start of product-params -->
                        <div class="product-tab-content product-params tab-content  pb-2 mb-4" id="scrollspyHeading3">
                            <div class="product-tab-title">
                                <div class="fontSize18 bold">مشخصات {{ $product['name'] }}</div>
                            </div>
                            <div class="expandable-text pt-1" style="height: auto">
                                <div class="expandable-text_text fa-num">
                                    <!-- start of params-list -->
                                    <div class="params-list">
                                        {{-- <div class="params-list-title">مشخصات کلی</div> --}}
                                        <ul id="params-list-div"></ul>
                                    </div>
                                    <!-- end of params-list -->
                                </div>
                            </div>
                        </div>
                        <!-- end of product-params -->
                        <!-- start of product-comments -->
                        @include('shop.product.write-comment', [
                            'itemId' => $product['id'],
                            'itemImg' => $product['img'],
                            'itemName' => $product['name'],
                            'sendComment' => route('api.product.comment.store', ['product' => $product['id']]),
                        ])
                        @include('shop.product.comments-show', [
                            'type' => 'product',
                            'fetchUrl' => route('api.product.comment.list', ['product' => $product['id']]),
                            'itemtId' => $product['id'],
                            'rate' => $product['rate'],
                            'rate_count' => $product['all_rates_count'],
                        ])
                        <!-- end of product-comments -->
                    </div>
                    <div class="col-xl-3 col-lg-4 d-lg-block d-none">
                        <div class="ui-sticky ui-sticky-top StickyMenuMoveOnTop">
                            <!-- start of product-seller-info -->
                            @include('shop.product.product_basket_card', ['product' => $product])
                            <!-- end of product-seller-info -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- <div class="remodal remodal-xs remodal-is-initialized remodal-is-opened" data-remodal-id="share-modal" data-remodal-options="hashTracking: false" tabindex="-1">
    <div class="remodal-header">
        <div class="remodal-title">اشتراک‌گذاری</div>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div>
    <div class="remodal-content">
        <div class="text-muted fs-7 fw-bold mb-3">
            با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید.
        </div>
        <div class="d-flex align-items-center border-top  py-3 mb-3">
            <div class="widget flex-grow-1 border-0 p-0 me-2">
                <div class="widget-content widget-socials">
                    <ul  class="align-items-center">
                        <li>
                            <a id="whatsapp" href="#" class="d-inline-flex share-link"><i class="ri-whatsapp-fill"></i></a>
                        </li>
                        <li>
                            <a id="telegram" class="d-inline-flex share-link-telegram"><i class="ri-telegram-fill"></i></a>
                        </li>
                        <li>
                            <a href="#" class="d-inline-flex share-link"><i class="ri-instagram-fill"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="btn btn-sm btn-primary copy-url-btn clipboard" data-copy="">کپی لینک
            </div> 
        </div>
    </div>
</div> --}}


        <script>
            $(document).ready(function() {

                let introHeight = $('#intro-container').height();

                if (introHeight >= 400) {
                    $("#show-more-container-for-intro").removeClass('hidden');
                }

                $("#show-more-container-for-intro .show-more").on('click', function() {
                    $('#intro-container-parent').addClass('max-height-auto');
                    $('#intro-container').addClass('max-height-auto');
                });

                $("#show-more-container-for-intro .show-less").on('click', function() {
                    $('#intro-container-parent').removeClass('max-height-auto');
                    $('#intro-container').removeClass('max-height-auto');
                });

                let productId;
                let maxCount = parseInt('{{ $product['available_count'] == -1 ? 100 : $product['available_count'] }}');

                try {
                    productId = location.pathname.split('/product/')[1].split('/')[0];
                } catch (e) {
                    document.location.href = '{{ route('home') }}';
                }

                $.ajax({
                    type: 'get',
                    url: '{{ route('api.product.show') }}' + '/' + productId,
                    headers: {
                        'accept': 'application/json'
                    },
                    success: function(res) {

                        let html = '';
                        for (var i = 0; i < res.galleries.length; i++) {
                            if (i == res.galleries.length - 1) {
                                if (res.galleries.length > 5)
                                    html += '<li class="moreImg" data-fancybox="gallery-a " data-src="' +
                                    res.galleries[i].img + '">';
                                else
                                    html += '<li class="notMoreImg" data-fancybox="gallery-a " data-src="' +
                                    res.galleries[i].img + '">';
                            } else
                                html += '<li data-fancybox="gallery-a " data-src="' + res.galleries[i].img +
                                '">';
                            html += '<img class="customBoxShadowGallery" src="' + res.galleries[i].img +
                                '" alt="' + res.galleries[i].alt + '"></li>';
                        }

                        $("#gallery").empty().append(html);

                        // if(res.galleries.length > 1) {
                        //     $(".product-gallery .gallery-thumbs ul li:last-child").addClass('more-img');
                        // }


                        let colors = '';
                        let property = '';
                        let params = '';

                        for (var i = 0; i < res.features.length; i++) {

                            let unit = undefined;

                            if (res.features[i].name === 'multicolor') {

                                $("#color-div").removeClass('hidden');
                                let val_label = res.features[i].value.split('__');

                                let prices = res.features[i].price !== undefined &&
                                    res.features[i].price !== null && res.features[i].price != '' ?
                                    res.features[i].price.split('$$') : null;

                                let pricesAfterOff = res.features[i].pricesAfterOff !== undefined &&
                                    res.features[i].pricesAfterOff !== null && res.features[i]
                                    .pricesAfterOff != '' ?
                                    res.features[i].pricesAfterOff.split('$$') : null;

                                let counts = res.features[i].available_count === undefined ||
                                    res.features[i].available_count == null ? null :
                                    res.features[i].available_count.split("$$");

                                let colors_keys = val_label[0].split('$$');
                                let colors_labels = val_label[1].split('$$');

                                for (var j = 0; j < colors_keys.length; j++) {

                                    colors +=
                                        '<div class="product-variant-item"><div class="custom-radio-circle">';
                                    colors += '<input data-label="' + colors_labels[j] + '" data-val="' +
                                        colors_keys[j] +
                                        '"" type="radio" class="custom-radio-circle-input" name="productColor"';
                                    if (j == 0) {

                                        if (prices !== null) {
                                            let p = prices.length > j ? prices[j] : '';
                                            let pA = pricesAfterOff != null && pricesAfterOff.length > j ?
                                                pricesAfterOff[j] : '';
                                            colors += 'data-price="' + p + '" data-after-price="' + pA +
                                                '" id="productColor0' + j + '" checked>';
                                            finalPrice = p;
                                            $(".price").empty().append(pA !== '' ? pA : p);
                                            if (pA !== '')
                                                $(".PriceBeforeOff").empty().append(p);
                                        } else if (counts !== null) {
                                            if (counts.length > j)
                                                colors += 'data-count="' + counts[j] +
                                                '" id="productColor0' + j + '" checked>';
                                            else
                                                colors += 'data-count="" id="productColor0' + j +
                                                '" checked>';

                                            finalAvailableCount = Math.min(counts[j], maxCount);
                                            showAvailableCount(parseInt(finalAvailableCount));
                                        }

                                        let html = '<div class="product-option">';
                                        html += '<span class="color" style="background-color: ' +
                                            colors_labels[j] + ';"></span>';
                                        html += '<span class="color-label ms-2">' + colors_keys[j] +
                                            '</span>';
                                        html += '</div>';

                                        $("#product_options").empty().append(html);
                                        wantedColor = colors_labels[j];
                                        wantedColorLabel = colors_keys[j];
                                        $("#product-color-variant-selected").empty().append(colors_keys[j]);

                                    } else {
                                        if (prices !== null) {
                                            let p = prices.length > j ? prices[j] : '';
                                            let pA = pricesAfterOff != null && pricesAfterOff.length > j ?
                                                pricesAfterOff[j] : '';
                                            colors += 'data-price="' + p + '" data-after-price="' + pA +
                                                '" id="productColor0' + j + '">';
                                        } else {
                                            if (counts.length > j)
                                                colors += 'data-count="' + counts[j] +
                                                '" id="productColor0' + j + '">';
                                            else
                                                colors += 'data-count="" id="productColor0' + j + '">';
                                        }
                                    }

                                    colors += '<label for="productColor0' + j +
                                        '" class="custom-radio-circle-label"';
                                    colors += 'data-variant-label="' + colors_keys[j] + '">';
                                    colors += '<span class="color" style="background-color: ' +
                                        colors_labels[j] + ';"';
                                    colors += 'data-bs-toggle="tooltip" data-bs-placement="bottom"';
                                    colors += 'title="' + colors_keys[j] + '" data-bs-original-title="' +
                                        colors_keys[j] + '" aria-label="' + colors_keys[j] + '"></span>';
                                    colors += '</label></div></div></div>';
                                }

                            } else if (res.features[i].available_count !== null ||
                                res.features[i].price !== null
                            ) {

                                unit = res.features[i].value.split(' ');
                                if (unit.length > 1)
                                    unit = unit.length == 1 ? unit[1] : unit.slice(1).join(' ');

                                let optionHtml =
                                    '<div class="product-variant-selected-container spaceBetween hidden" >' +
                                    '<div class="product-variant-selected-label bold mb-3 seller d-flex justify-content-center align-items-center pl-2 fontSize18">' +
                                    res.features[i].name + '</div>' +
                                    '<div class="line mr-15 ml-15"></div>' +
                                    '<div class="whiteSpaceNoWrap"><span id="selected_option_for_feature_' +
                                    res.features[i].id + '"></span><span>&nbsp;</span>';

                                optionHtml += '</div>';
                                optionHtml += '</div>';
                                optionHtml += '<select name="productOption" data-id="' + res.features[i]
                                    .id + '" id="dynamic_options_' + res.features[i].id +
                                    '" class="select2 form-control widthAuto mb-4"></select>';

                                $("#dynamic_multi_choice_features").append(optionHtml);

                                let vals = res.features[i].value.split('__')[0].split("$$");

                                let prices = res.features[i].price == null ? null : res.features[i].price
                                    .split("$$");
                                let pricesAfterOff = res.features[i].pricesAfterOff !== undefined &&
                                    res.features[i].pricesAfterOff !== null && res.features[i]
                                    .pricesAfterOff != '' ?
                                    res.features[i].pricesAfterOff.split('$$') : null;

                                let counts = res.features[i].available_count == null ? null : res.features[
                                    i].available_count.split("$$");

                                let sizes = "";

                                for (var j = 0; j < vals.length; j++) {

                                    sizes += '<option value="' + vals[j] + '" ';

                                    if (j == 0) {

                                        if (unit === undefined)
                                            $('#selected_option_for_feature_' + res.features[i].id).empty()
                                            .append(vals[0]);
                                        else
                                            $('#selected_option_for_feature_' + res.features[i].id).empty()
                                            .append(vals[0] + ' ' + unit);

                                        wantedFeature = vals[0];

                                        if (prices != null) {

                                            let p = prices[j];
                                            let pA = pricesAfterOff !== null ? pricesAfterOff[j] : '';

                                            sizes += 'data-price="' + p + '"';

                                            if (pA !== '')
                                                sizes += ' data-after-price="' + pA + '"';

                                            finalPrice = p;

                                            $(".price").empty().append(pA !== '' ? pA : p);

                                            if (pA !== undefined)
                                                $(".PriceBeforeOff").empty().append(pA);
                                        } else {
                                            sizes += 'data-count="' + counts[j] + '"';
                                            finalAvailableCount = Math.min(counts[j], maxCount);
                                            showAvailableCount(parseInt(finalAvailableCount));
                                        }
                                    } else {
                                        if (prices != null) {

                                            let p = prices[j];
                                            let pA = pricesAfterOff !== null ? pricesAfterOff[j] : '';

                                            sizes += 'data-price="' + p + '"';

                                            if (pA !== '')
                                                sizes += ' data-after-price="' + pA + '"';
                                        } else
                                            sizes += 'data-count="' + counts[j] + '"';
                                    }

                                    if (unit === undefined)
                                        sizes += '>' + vals[j] + '</option>';
                                    else
                                        sizes += '>' + vals[j] + ' ' + unit + '</option>';

                                }

                                $("#dynamic_options_" + res.features[i].id).append(sizes);
                            } else if (res.features[i].show_in_top == 1) {

                                property += '<li><span class="label colorBlueWhite px-1">' + res.features[i]
                                    .name + '</span><span> : </span>';
                                property += '<span class="title px-1">' + res.features[i].value +
                                    '</span></li>';

                            }

                            params += '<li>';

                            if (res.features[i].name === 'multicolor')
                                params += '<span class="param-title colorBlueWhite font600">رنگ</span>';
                            else
                                params += '<span class="param-title colorBlueWhite font600">' + res
                                .features[i].name + '</span>';

                            let featureValTmp;

                            if (
                                res.features[i].name === 'multicolor' ||
                                res.features[i].available_count !== null ||
                                res.features[i].price !== null
                            ) {
                                let vals_tmp = res.features[i].value.split(' ')[0].split("__")[0].split(
                                    '$$');
                                featureValTmp = vals_tmp.join('، ');
                            } else
                                featureValTmp = res.features[i].value;

                            if (unit !== undefined)
                                featureValTmp += ' ' + unit;

                            params += '<span class="param-value fontSize16">' + featureValTmp + '</span>';
                            params += '</li>';

                        }

                        $("#params-list-div").empty().append(params);


                        if (colors != '')
                            $("#product-colors-variants").empty().append(colors);


                        $("#properties").append(property);
                    }
                });


                let critical_point = parseInt('{{ $critical_point }}');

                function showAvailableCount(count) {

                    if (count > critical_point) {
                        $(".show_if_available").removeClass('hidden');
                        $(".availableCount").empty().append('<span></span>');
                    } else if (count === 0) {
                        $(".show_if_available").addClass('hidden');
                        $(".availableCount").empty().append('<span>اتمام موجودی</span>');
                    } else {
                        $(".show_if_available").removeClass('hidden');
                        $(".availableCount").empty().append('<span>تنها <span class="mx-2">' + count +
                            '</span>عدد در انبار باقیست - پیش از اتمام بخرید</span>');
                    }

                }


                $(document).on("click", "input[name='productColor']", function() {

                    if ($(this).attr('data-price') !== undefined) {
                        let p = $(this).attr('data-price');
                        let pA = $(this).attr('data-after-price');
                        finalPrice = p;
                        $(".price").empty().append(pA !== undefined && pA.length > 0 ? pA : p);
                        if (pA !== undefined && pA.length > 0)
                            $(".PriceBeforeOff").empty().append(p);
                    } else {
                        finalAvailableCount = Math.min($(this).attr('data-count'), maxCount);
                        showAvailableCount(parseInt(finalAvailableCount));
                    }

                    wantedColor = $(this).attr('data-label');
                    wantedColorLabel = $(this).attr('data-val');

                    let html = '<div class="product-option">';
                    html += '<span class="color" style="background-color: ' + wantedColor + ';"></span>';
                    html += '<span class="color-label ms-2">' + wantedColorLabel + '</span>';
                    html += '</div>';

                    $("#product_options").empty().append(html);
                    $("#product-color-variant-selected").empty().append($(this).attr('data-val'));
                });

                $(document).on("change", "select[name='productOption']", function() {

                    let selectedOption = $(this).find(":selected");

                    if (selectedOption.attr('data-price') !== undefined) {

                        let p = selectedOption.attr('data-price');
                        let pA = selectedOption.attr('data-after-price');
                        finalPrice = p;
                        $(".price").empty().append(pA !== undefined && pA.length > 0 ? pA : p);
                        if (pA !== undefined && pA.length > 0)
                            $(".PriceBeforeOff").empty().append(p);
                    } else {
                        finalAvailableCount = Math.min(selectedOption.attr('data-count'), maxCount);
                        showAvailableCount(parseInt(finalAvailableCount));
                    }

                    wantedFeature = selectedOption.val();
                    $('#selected_option_for_feature_' + $(this).attr('data-id')).empty().append(selectedOption
                        .text());

                });

                let star = "";
                let roundRatting = Math.floor('{{ $product['rate'] }}');
                for (var i = 5; i >= 1; i--) {
                    if (i <= roundRatting)
                        star += '<i class="icon-visit-star me-1 fontSize21"></i>';
                    else
                        star += '<i class="icon-visit-staroutline me-1 fontSize14"></i>';
                }
                $(".rattingToStar").empty().append(star);

                $('#nav1').on('click', function() {
                    $(".my-nav-link").removeClass('active');
                    $('#nav1').addClass('active');
                });

                $('#nav2').on('click', function() {
                    $(".my-nav-link").removeClass('active');
                    $('#nav2').addClass('active');
                });

                $('#nav3').on('click', function() {
                    $(".my-nav-link").removeClass('active');
                    $('#nav3').addClass('active');
                });
                var width = $(document).width();
                if (width < 768) {
                    $('#commentNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading4').offset().top - 60
                        });
                    });

                    $('#propertyNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading3').offset().top - 60
                        });
                    });

                    $('#checkNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading1').offset().top - 60
                        });
                    });

                } else {
                    $('#commentNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading4').offset().top - 210
                        });
                    });

                    $('#propertyNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading3').offset().top - 210
                        });
                    });

                    $('#checkNavLink').click(function() {
                        $('html, body').animate({
                            'scrollTop': $('#scrollspyHeading1').offset().top - 210
                        });
                    });
                }
            });
        </script>

    @stop

    @section('footer')
        @parent
    @stop

    @section('extraJS')
        @parent
        <script src="{{ asset('theme-assets/js/home.js') }}"></script>
    @stop
