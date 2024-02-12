<div class="w-100 overFlowHidden marginTop0 TopParentBannerMoveOnTop">
    <!-- start of main-slider -->
    <div class="swiper main-swiper-slider">
        <!-- Additional required wrapper -->
        <div id="slider" class="swiper-wrapper">
            {{-- <div class="swiper-slide main-swiper-slide opacity1">
                <a href="#"
                    style="background-image: url(./theme-assets/images/slider/main/04.jpg);border-radius:0;">
                    <img  style="border-radius:0;" src="./theme-assets/images/slider/main/04.jpg" alt="">
                </a>
            </div> --}}
        </div> 
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <!-- end of main-slider -->
</div>
        <script>
         var width = window.innerWidth;
         $.ajax({
             type: 'get',
             url: '{{ route('api.slider') }}',
             headers: {
                 'accept': 'application/json'
             },
             success: function(res) {
                 var html= "";

                 if(res.status === "ok") {
                      if (width > 1000) {
                         for(var i = 0; i < res.data.length; i++) {
                             html += '<div class="swiper-slide main-swiper-slide"><a target="_blank" href=' + res.data[i].href + ' style="background-image: url(' + res.data[i].img_large + ')!important;border-radius:0;"><img style="border-radius:0;" class="imgResponsive" src="' + res.data[i].img_large + '" alt=""></a></div>';
                         }
                      }else if (width > 520) {
                          for(var i = 0; i < res.data.length; i++) {
                             html += '<div class="swiper-slide main-swiper-slide"><a target="_blank" href=' + res.data[i].href + ' style="background-image: url(' + res.data[i].img_mid + ')!important;border-radius:0;"><img style="border-radius:0;" class="imgResponsive" src="' + res.data[i].img_mid + '" alt=""></a></div>';
                          }
                      }else {
                          for(var i = 0; i < res.data.length; i++) {
                              html += '<div class="swiper-slide main-swiper-slide"><a target="_blank" href=' + res.data[i].href + ' style="background-image: url(' + res.data[i].img_small + ')!important;border-radius:0;"><img style="border-radius:0;" class="imgResponsive" src="' + res.data[i].img_small + '" alt=""></a></div>';
                          }
                      } 
                    $("#slider").empty().append(html);
                 }
             }
         });

    </script>