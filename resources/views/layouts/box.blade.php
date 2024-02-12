<!-- start of box -->
<div id="{{ $id }}" class="w-100 mb-5">
    <div class="container">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20"> 
                <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">{{ $title }}
            </span>
        </div>
    <div class="ui-box-content">
        <!-- Slider main container -->
        <div class="swiper product-swiper-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                @for($i = 0; $i < 5; $i++)
                    <!-- Slides -->
                    <a href="#" class="cursorPointer">
                        <div class="swiper-slide customWidthBox">
                        <!-- start of product-card -->
                        <div class="product-card customBorderBoxShadow">
                            <div class="SimmerParent">
                            <div class="shimmerBG media pt-1">
                            </div>
                            <div class="p-32 mt-1">
                                <div class="shimmerBG title-line"></div>
                                <div class="shimmerBG content-line"></div>
                                <div class="shimmerBG title-line"></div>
                                <div class="shimmerBG title-line py-2"></div>
                                <div class="shimmerBG content-line"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end of product-card -->
                        </div>
                    </a>
                @endfor
                
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