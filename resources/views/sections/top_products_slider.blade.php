<!-- start of box -->
<div id="{{ $id }}" class="w-100 my-slider mb-5 hidden">
    <div class="container">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20"> 
                <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">{{ $title }}
            </span>
            @if(!isset($disableShowAll) || !$disableShowAll)
                <span class="alignItemsCenter colorBlue"><a target="_blank" class="hoverBold" href="{{ isset($href) ? $href : '' }}">مشاهده همه</a></span>
            @endif
        </div>
        <div class="ui-box-content">
            <!-- Slider main container -->
            <div class="swiper {{ $key }}-product-swiper-slider">
                <!-- Additional required wrapper -->
                <div id="{{ $key }}sSlider" class="swiper-wrapper">
                    <!-- Slides -->
                    <div id="{{ $key }}sSample" class="hidden">
                        <div>
                            @include('shop.productCard', ['key' => $key, 'autoHeight' => $title == 'محصولات مشابه'])
                        </div>
                    </div>
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


<script>

    $(document).ready(function() {

        $.ajax({
            type: 'get',
            url: '{{ isset($api) ? $api : route('api.product.list', ['orderBy' => $searchKey, 'limit' => 8]) }}',
            success: function(res) {
                let html = renderProductSlider(res.data, '{{ $key }}');
                $("#" + '{{ $key }}' + "sSlider").empty().append(html).removeClass('hidden');
                $("#" + '{{ $not_fill_id }}').remove();
                $("#" + '{{ $id }}').removeClass('hidden');
                
                const productSpecialsSwiperSlider = new Swiper(
                    "." + '{{ $key }}' + "-product-swiper-slider",
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