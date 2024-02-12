<footer class="page-footer pt-2 backgroundWhite b-0" style="direction: rtl">
    <div class="container">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20"> <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">تماس با ما</span>        </div>
        <div class="row mb-3">
            <div class="col-lg-3 col-md-5">
                <div class="widget widget-footer mb-4">
                        <div class="widget-title">پشتیبانی</div>
                        <div class="colorYellow customPaddingTopBottom10">هفت روز هفته از ساعت ۸ الی ۱۷</div>
                        @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                        <div class="textColor customPaddingTopBottom10">تلفن پشتیبانی : ۸۸۸۱۹۵۶۸-۰۲۱</div>
                        @else
                        <div class="textColor customPaddingTopBottom10">تلفن پشتیبانی : 88819562-۰۲۱</div>
                        @endif
                    <div class="widget-content widget-socials">
                        <ul>
                            <li><a href="#"><i class="ri-facebook-circle-fill"></i></a></li>
                            <li><a href="#"><i class="ri-instagram-fill"></i></a></li>
                            <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
                            <li><a href="#"><i class="ri-telegram-fill"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 ol-sm-6 col-12">
                <div class="widget widget-footer">
                    @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                    <div class="widget-title">از جدیدترین تخفیف ها باخبر شوید</div>
                    @else
                    <div class="widget-title">از تخفیف های ما با خبر شوید</div>
                    @endif
                    <div class="widget-content widget-newsletter">
                        <div class="form-element-row with-btn align-Items-end">
                            <input onkeypress="return isEmail(event) || isNumber(event)" id="footer_mail" type="text" class="form-control"
                                placeholder="آدرس پست الکترونیک خود را وارد کنید">
                            <button id="submitMailBtn" class="btn btn-primary backgroundGray alignSelfEnd customBtnAddress">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 ol-sm-6 col-12">
                <div class="widget widget-footer">
                    <div class="widget-title">برای مشتریان</div>
                    <div class="widget-content widget-list">
                        <ul>
                            @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                                <li><a href="https://hcshop.taci.ir/blog/15/%D8%B3%DB%8C%D8%A7%D8%B3%D8%AA_%D8%AD%D8%B1%DB%8C%D9%85_%D8%AE%D8%B5%D9%88%D8%B5%DB%8C">سیاست حریم خصوصی</a></li>
                                <li><a href="https://hcshop.taci.ir/blog/17/%D9%82%D9%88%D8%A7%D9%86%DB%8C%D9%86_%D9%88_%D9%85%D9%82%D8%B1%D8%B1%D8%A7%D8%AA">قوانین و مقررات</a></li>
                                <li><a href="https://hcshop.taci.ir/blog/12/%D8%AF%D8%B1%D8%A8%D8%A7%D8%B1%D9%87_%D9%85%D8%A7">درباره ما</a></li>
                                <li><a href="https://hcshop.taci.ir/blog/16/%D9%86%D8%AD%D9%88%D9%87_%D8%A7%D8%B1%D8%B3%D8%A7%D9%84_%DA%A9%D8%A7%D9%84%D8%A7_%D9%88_%D8%B9%D9%88%D8%AF%D8%AA">نحوه ارسال کالا و عودت</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="widget widget-footer">
                    <div class="widget-title">نماد اطمینان</div>
                    <div class="widget-content widget-list">
                        <ul>
                            <li><a href="https://www.mcth.ir">وزارت میراث فرهنگی، صنایع دستی و گردشگری</a></li>
                            <li><a href="https://www.taci.ir">کانون جهانگردی و اتومبیلرانی جمهوری اسلامی ایران</a></li>
                            <li><a href="https://www.visitiran.ir">سامانه گردشگری ویزیت ایران</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="customBackgroundWhite">
            <div class="container p-4">
                <div class="col-lg-12 mb-4">
                    <div class="expandable-text pt-1" style="height: 100px;">
                        <div class="expandable-text_text fa-num">
                            @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                            <div class="fs-6 fw-bold mb-2">سامانه فروش صنایع دستی و هنرهای تزئینی 
                            </div>
                            @else
                            <div class="fs-6 fw-bold mb-2">دبیرخانه رویدادها 
                            </div>
                            @endif
                            <div id="footerDesc" class="fs-7 text-secondary text-justify">
                            </div>
                        </div>
                        <div class="customBackgroundWhite expandable-text-expand-btn justify-content-start text-sm">
                            <span class="show-more active colorBlue hoverBold">
                                مشاهده بیشتر <i class="ri-arrow-down-s-line ms-2"></i>
                            </span>
                            <span class="show-less d-none colorBlue hoverBold">
                                بستن <i class="ri-arrow-up-s-line ms-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="copy-right text-center text-muted py-3">
            کلیه حقوق این سایت به متعلق به شرکت سیسوتک می باشد
        </div>
    
</footer>
<script>

    $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '{{ route('api.getDesc') }}',
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {
                if(res.status === "ok") {
                    $("#footerDesc").append(res.data);
                    
                }
            }
        });

        $("#submitMailBtn").on('click', function() {
            $.ajax({
                type: 'post',
                url: '{{ route('api.submitMail') }}',
                data: {
                    'mail': $("#footer_mail").val()
                },
                headers: {
                    'accept': 'application/json'
                },
                success: function(res) {
                    if(res.status === "ok") {
                        alert('عملیات موردنظر با موفقیت انجام شد.');
                    }
                }
            });
        });
        
    });
        
</script>