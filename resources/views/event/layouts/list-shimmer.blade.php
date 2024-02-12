<div id="shimmer" class="hidden" style="display: flex; flex-wrap: wrap; gap: 10px;">
    @for ($i = 0; $i < 4; $i++)
        <!-- Slides -->
        <a href="#" class="cursorPointer">
            <div class="swiper-slide customEventWidthBox ml-0">
                <!-- start of product-card -->
                <div class="product-card customEventBorderBox">
                    <div class="SimmerParent">
                        <div class="shimmerBG media pt-1">
                        </div>
                        <div class="p-32 mt-4">
                            <div class="shimmerBG title-line mt-3"></div>
                            <div class="shimmerBG content-line mt-3"></div>
                            <div class="shimmerBG title-line mt-3"></div>
                        </div>
                    </div>
                </div>
                <!-- end of product-card -->
            </div>
        </a>
    @endfor
</div>
