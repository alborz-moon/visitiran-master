@extends('layouts.structure')
@section('header')

    @parent
    <script src="{{ asset('theme-assets/dropzone/dropzone.js?v=1.2') }}"></script>
    <link rel="stylesheet" href="{{ asset('theme-assets/dropzone/dropzone.css') }}">
    <script>
        var myPreventionFlag = false;
    </script>
@stop
@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row mb-5">
                @include('shop.profile.layouts.profile_menu')
                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="ui-box bg-white mb-5">
                        <div class="d-flex spaceBetween align-items-center">
                            <div class="ui-box-title">مشاهده </div>
                            <a href="{{ route('profile.my-tickets') }}"
                                class="px-3 b-0 btnHover backColorWhite colorBlue fontSize18">بازگشت</a>
                        </div>
                        <div class="ui-box-content">
                            <!-- start of tickets -->
                            <div class="tickets">
                                <!-- start of ticket -->
                                <div class="ticket fa-num">
                                    <div class="avatar"></div>
                                    <div class="text">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
                                        طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف
                                        بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و
                                        آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت
                                        بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در
                                        زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود
                                        در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
                                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی
                                        اساسا مورد استفاده قرار گیرد.
                                    </div>
                                    <div class="date">25 دی 1400</div>
                                </div>
                                <!-- end of ticket -->
                                <!-- start of ticket -->
                                <div class="ticket reply fa-num">
                                    <div class="avatar staff"></div>
                                    <div class="text">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                        طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
                                        ابزارهای کاربردی می باشد.
                                    </div>
                                    <div class="date">26 دی 1400</div>
                                </div>
                                <!-- end of ticket -->
                            </div>
                            <!-- end of tickets -->
                            <div class="my-4"></div>
                            <div class="ui-box-title p-0 mb-4">
                                ارسال پاسخ
                            </div>
                            <!-- start of add-ticket-form -->
                            <form action="#" class="add-ticket-form">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- start of form-element -->
                                        <div class="form-element-row mb-5">
                                            <label class="label">پیام</label>
                                            <textarea rows="5" class="form-control" placeholder="متن پیام"></textarea>
                                        </div>
                                        <!-- end of form-element -->
                                    </div>
                                    {{-- for test --}}
                            </form>
                            <div class="col-12 zIndex0">
                                <!-- start of form-element -->
                                <div class="uploadBody">
                                    <div class="uploadBorder">
                                        <div class="uploadBodyBox">
                                            <div class="uploadTitleText">بارگذاری فایل محتوا</div>
                                            <form action="{{ route('api.testUpload') }}" class="dropzone uploadBox"
                                                id="my-awesome-dropzone">
                                                {{ csrf_field() }}
                                            </form>
                                            <div id="dropZoneErr" style="margin-top: 25px; font-size: 1.2em; color: red;"
                                                class="hidden">شما اجازه بارگذاری چنین فایلی را ندارید.</div>
                                            <div class="uploadّFileAllowed">حداکثر فایل مجاز: 100 مگابایت</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of form-element -->
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">ارسال پاسخ <i
                                        class="ri-ball-pen-line ms-2"></i></button>
                            </div>
                        </div>
                        {{-- </form> --}}

                        <!-- end of add-ticket-form -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
    <script>
        Dropzone.options.myAwesomeDropzone = {
            paramName: "img_file", // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            timeout: 180000,
            parallelUploads: 1,
            chunking: false,
            forceChunking: false,
            accept: function(file, done) {
                done();
            },
            init: function() {
                this.on('completemultiple', function() {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
                this.on("queuecomplete", function(file) {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
                this.on("complete", function(file) {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
                this.on("success", function(file) {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
                this.on("canceled", function(file) {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
                this.on("error", function(file) {
                    // if(myPreventionFlag)
                    //     $("#dropZoneErr").removeClass('hidden');
                    // else
                    //     location.reload();
                });
            }
        };
    </script>
@stop
