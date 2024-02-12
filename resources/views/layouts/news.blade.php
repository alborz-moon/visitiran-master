<div id="customCardNewsSample" class="hidden cursorPointer newsHref">
    <!-- Slides -->
    <div class="swiper-slide customCardNews mb-5">
        <!-- start of product-card -->
        <div class="product-card customBoxNews">
            <div>
                <a class="newsHref" href="#">
                    <img id="newsImg" class="customImgNews">
                </a>
            </div>
            <div class="product-card-body">
                <h2 class="product-title mt-3">
                    <a id="newsHeader" class="textColor fontSize18 bold newsHref" href="#"></a>
                </h2>
                <div class="product-variant">
                    <span id="newsTag" class="colorWhite customBoxLabel"></span>
                </div>
                <div class="mt-3 mb-3 heightTextNews">
                    <div id="newsDigest" class="fontSize12 textColor textAlignJustify"></div>
                </div>
            </div>
            <div class="product-card-footer d-flex justify-content-end">
                <a class="newsHref" href="#"> 
                    <div  class="cursorPointer arrowLeftIcon positionAbsolute customArrowLeftIcon backGray customIconBottom12">
                    <img src="{{ asset('theme-assets/images/svg/ionic-ios-arrow-round-back.svg') }}">
                    </div>
                </a>
            </div>
        </div>
        <!-- end of product-card -->
    </div>
</div>

<!-- start of box -->
<div class="w-100 mb-5 backgroundWhite">
    <div class="container pt-2 ">
    <div id="news-swiper-slider-parent" class="ui-box-content backgroundWhite ">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20"> <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">تازه ها</span>
            <span class="alignItemsCenter colorBlue"><a class="hoverBold" href="{{ route('blog-list') }}">مشاهده همه</a></span>
        </div>
    </div>
    </div>
</div>
<!-- end of box -->

<script>

    $(document).ready(function() {

        $.ajax({
            type: 'get',
            url: '{{ route('api.blog.list') }}',
            success: function(res) {
                let data = res.data;
                let html = '';
                data.forEach(elem => {
                    $(".newsHref").attr('href', elem.href);
                    $("#newsImg").attr('src', elem.img).attr('alt', elem.alt);
                    $("#newsHeader").text(elem.header);
                    $("#newsDigest").text(elem.digest);
                    $("#newsTag").text(elem.tags);
                    let id = elem.id;
                    var newElem = $("#customCardNewsSample").html();
                    newElem.replace("newsHref", "newsHref_" + id);
                    newElem.replace("newsImg", "newsImg_" + id);
                    newElem.replace("newsHeader", "newsHeader_" + id);
                    newElem.replace("newsTag", "newsTag_" + id);
                    newElem.replace("newsDigest", "newsDigest_" + id);
                    html += newElem;
                });

                let hh = '<div class="swiper news-swiper-slider">';
                hh += '<div id="topNewsSlider" class="swiper-wrapper">';
                hh += html;
                hh += '</div>';
                hh += '<div class="swiper-pagination"></div>';
                hh += '<div class="swiper-button-prev"></div>';
                hh += '<div class="swiper-button-next"></div>';
                hh += '</div>';

                $("#news-swiper-slider-parent").append(hh);
                $("#customCardNewsSample").remove();

                const productSpecialsSwiperSlider = new Swiper(
                    ".news-swiper-slider",
                    {
                        // Optional parameters
                        spaceBetween:10,

                        // Navigation arrows
                        navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                        },

                        breakpoints: {
                        1200: {
                            slidesPerView: 3,
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