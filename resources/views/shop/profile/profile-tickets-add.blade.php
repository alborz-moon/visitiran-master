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
                            <div class="ui-box-title">ایجاد تیکت جدید</div>
                            <a href="{{ route('profile.my-tickets') }}"
                                class="px-3 b-0 btnHover backColorWhite colorBlue fontSize18">بازگشت</a>
                        </div>
                        <div class="ui-box-subtitle">فرم زیر را پر کنید (توضیحات کامل تر روند پاسخ دهی را کوتاه تر
                            می
                            کند.)</div>
                        <div class="ui-box-content">
                            <!-- start of add-ticket-form -->
                            {{-- <form action="/sad" class="add-ticket-form"> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">موضوع</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">بخش</label>
                                        <select class="select2" name="department" id="department">
                                            <option value="0">-</option>
                                            <option value="1">پیشنهاد</option>
                                            <option value="2">انتقاد یا شکایت</option>
                                            <option value="3">پیگیری سفارش</option>
                                            <option value="4">خدمات پس از فروش</option>
                                            <option value="5">مرجوع شدن کالا</option>
                                            <option value="6">حسابداری و امور مالی</option>
                                            <option value="7">سایر موضوعات</option>
                                        </select>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                {{-- <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">اولویت</label>
                                        <select class="select2" name="priority" id="priority">
                                            <option value="0">انتخاب کنید</option>
                                            <option value="0">عادی</option>
                                            <option value="0">مهم</option>
                                            <option value="0">خیلی مهم</option>
                                        </select>
                                    </div>
                                    <!-- end of form-element -->
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">پیام</label>
                                        <textarea rows="5" class="form-control" placeholder="متن پیام"></textarea>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-12 zIndex0">

                                    {{-- <div class="uploadBody">
                                        <div class="uploadBorder">
                                            <div class="uploadBodyBox">
                                                <div class="uploadTitleText">بارگذاری فایل محتواasdasd</div>
                                                <form action="{{ route('api.testUpload') }}" class="dropzone uploadBox"
                                                    id="my-awesome-dropzone">
                                                    {{ csrf_field() }}
                                                </form>
                                                <div id="dropZoneErr"
                                                    style="margin-top: 25px; font-size: 1.2em; color: red;" class="hidden">
                                                    شما اجازه بارگذاری چنین فایلی را ندارید.</div>
                                                <div class="uploadّFileAllowed">حداکثر فایل مجاز: 100 مگابایت</div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{--                                     
                                    @include('event.launcher.dropZone', [
                                        'label' => 'بارگذاری فایل محتوا',
                                        'key' => 'tickets_file',
                                        'camelKey' => 'ticketsFile',
                                        'maxFiles' => 1,
                                        'route' => route('launcher.update', ['launcher' => $formId]),
                                    ]) --}}

                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">ثبت و ارسال <i
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

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
    <script></script>
@stop
