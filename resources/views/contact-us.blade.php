
@extends('layouts.structure')
@section('header')

    @parent

    <link rel="stylesheet" href="{{URL::asset('theme-assets/bootstrap-datepicker.css?v=1')}}">
    <script src="{{URL::asset("theme-assets//bootstrap-datepicker.js")}}"></script>
@stop
@section('content')
            <main class="page-content">
            <div class="container">
                <!-- start of box => contact-us -->
                <div class="ui-box bg-white">
                    <div class="ui-box-title fs-5 fw-bold">تماس با ما</div>
                    <div class="ui-box-subtitle flex-wrap">
                        لطفاً پیش از ارسال پست الکترونیک یا تماس تلفنی، ابتدا <a href="#" class="link mx-2">پرسش های متداول</a>
                        را
                        مشاهده کنید.
                    </div>
                    <div class="ui-box-content">
                        <div class="fs-7 text-secondary mb-5">برای پیگیری یا سوال درباره سفارش و ارسال پیام بهتر است از
                            فرم
                            زیر استفاده کنید.</div>
                        <!-- start of contact-us-form -->
                        <form action="#" class="contact-us-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">موضوع</label>
                                        <select class="select2" name="subject" id="subject">
                                            <option value="0">انتخاب موضوع</option>
                                            <option value="0">پیشنهاد</option>
                                            <option value="0">انتقاد یا شکایت</option>
                                            <option value="0">پیگیری سفارش</option>
                                            <option value="0">خدمات پس از فروش</option>
                                            <option value="0">استعلام گارانتی</option>
                                            <option value="0">مدیریت</option>
                                            <option value="0">حسابداری و امور مالی</option>
                                            <option value="0">سایر موضوعات</option>
                                        </select>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">نام و نام خانوادگی</label>
                                        <input type="text" class="form-control" placeholder="نام کامل" disabled>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">پست الکترونیک</label>
                                        <input onkeypress="return isEmail(event) || isNumber(event)" type="text" class="form-control" placeholder="example@example.com">
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-md-6">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">تلفن تماس</label>
                                        <input type="text" class="form-control" placeholder="09xxxxxxxxx">
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-12">
                                    <!-- start of form-element -->
                                    <div class="form-element-row mb-5">
                                        <label class="label">پیام</label>
                                        <textarea rows="5" class="form-control" placeholder="متن پیام"></textarea>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-12">
                                    <!-- start of form-element -->
                                    <div class="form-element-row form-element-row-file mb-5">
                                        <div class="text-center">
                                            <div class="fs-6 fw-bold text-dark">عکس یا ویدیو خود را بارگذاری کنید.</div>
                                            <div class="fs-7 fw-bold text-muted mb-4">( حداکثر ۵ تصویر jpeg یا PNG
                                                حداکثر یک
                                                مگابایت، یک ویدیو MP4 حداکثر ۵۰ مگابایت )</div>
                                        </div>
                                        <div class="custom-input-file">
                                            <input type="file" class="custom-input-file-input" name="attachment"
                                                id="attachment">
                                            <label for="attachment" class="custom-input-file-label">
                                                <span class="label">
                                                    <i class="ri-arrow-up-fill me-1"></i> انتخاب عکس یا ویدئو
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">ثبت و ارسال</button>
                                </div>
                            </div>
                        </form>
                        <!-- end of contact-us-form -->
                    </div>
                </div>
                <!-- end of box => contact-us -->
            </div>
        </main>
    <input id="date_input_start_formatted" type="hidden" />
    <input id="date_input_stop_formatted" type="hidden" />
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
    <script> 
        $(document).ready(function(){
            
            $(document).on('click', "#startSessionBtn", function () {
                var timeStart =$('#time_input_start').val();
                var dateStart = $('#date_input_start_formatted').val();
                var dateStart2 = $('#date_input_start').val();
                if (timeStart.length == 0 || dateStart.length == 0){
                    showErr("تاریخ پایان و زمان پایان را وارد کنید");
                    return;
                }else{
                    $('#setDateStart').val(timeStart + ' ' + dateStart2);                
                    $(".remodal-close").click();
                }
            });
            $(document).on('click', "#stopSessionBtn", function () {
                var timeStop = $('#time_input_stop').val();
                var dateStop = $('#date_input_stop_formatted').val();
                var dateStop2 = $('#date_input_stop').val();
                if (timeStop.length == 0 || dateStop.length == 0){
                    showErr("تاریخ پایان و زمان پایان را وارد کنید");
                    return;
                }else{
                    $('#setDateStop').val(timeStop + ' ' + dateStop2);
                    $(".remodal-close").click();               
                }
            });
        });
        var datePickerOptions = {
            numberOfMonths: 1,
            showButtonPanel: true,
            dateFormat: "DD d M سال yy",
            altFormat:"yy/mm/dd",
            altField: $("#date_input_start_formatted")
        };
        var datePickerOptionsEnd = {
            numberOfMonths: 1,
            showButtonPanel: true,
            dateFormat: "DD d M سال yy",
            altFormat:"yy/mm/dd",
            altField: $("#date_input_stop_formatted")
        };

        $("#date_input_start").datepicker(datePickerOptions);
        $("#date_input_stop").datepicker(datePickerOptionsEnd);
    </script>
@stop