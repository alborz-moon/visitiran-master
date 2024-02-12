@extends('layouts.structure')
@section('header')

    @parent
    <script src="{{URL::asset("theme-assets/js/moment.js")}}"></script>

    <link rel="stylesheet" href="{{URL::asset('theme-assets/css/bootstrap-material-datetimepicker.css')}}">
    <script src="{{URL::asset("theme-assets/js/bootstrap-material-datetimepicker.js")}}"></script>

    <link rel="stylesheet" href="{{URL::asset('theme-assets/bootstrap-datepicker.css?v=1')}}">
    <script src="{{URL::asset("theme-assets//bootstrap-datepicker.js")}}"></script>
    
    <script src="{{asset('theme-assets/js/Utilities.js')}}"></script>
    
@stop
@section('content')
        <main class="page-content TopParentBannerMoveOnTop">
        <div class="container">
            <div class="row mb-5">
                <?php $isEditor = Auth::user()->isEditor(); ?>
                
                @if(!$isEditor)
                    @include('event.launcher.launcher-menu')
                @endif

                <div class="{{ $isEditor ? 'col-xl-12 col-lg-12 col-md-12' : 'col-xl-9 col-lg-8 col-md-7'}}">
                    
                    @include('event.layouts.shimmer')
                    
                    <div id="hiddenHandler" class="hidden">
                    <div class="d-flex spaceBetween align-items-center">
                        <span class="colorBlack  fontSize15 bold d-none d-md-block">ایجاد رویداد </span>
                        <ul class="checkout-steps mt-4 mb-3 w-100">
                            <li class="checkout-step-active">
                                <a href="{{ route('update-event', ['event' => $id]) }}"><span class="checkout-step-title" data-title="اطلاعات کلی"></span></a>
                            </li>
                            <li class="checkout-step-active">
                                <a href="{{ route('addSessionsInfo', ['event' => $id]) }}"><span class="checkout-step-title" data-title="زمان برگزاری"></span></a>
                            </li>
                            <li class="checkout-step-active">
                                <a><span class="checkout-step-title" data-title="ثبت نام و تماس"></span></a>
                            </li>
                            <li>
                                <a href="{{ route('addGalleryToEvent', ['event' => $id]) }}"><span class="checkout-step-title" data-title="اطلاعات تکمیلی"></span></a>
                            </li>
                        </ul>
                        <a href="{{ route('addSessionsInfo', ['event' => $id]) }}" class="px-3 b-0 btnHover backColorWhite colorBlack fontSize18">بازگشت</a>
                    </div>
                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">تاریخ ثبت نام</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div data-remodal-target="time-and-date-start-modal" class="fs-7 text-dark">تاریخ و ساعت شروع</div>
                                        <div class="py-2">
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="setDateStart" data-remodal-target="time-and-date-start-modal" type="text" class="form-control" style="direction: rtl" placeholder="تاریخ و ساعت شروع" disabled>
                                                <button data-input-id="setDateStart" data-remodal-target="time-and-date-start-modal" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div data-remodal-target="time-and-date-stop-modal" class="fs-7 text-dark">تاریخ و ساعت پایان</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="setDateStop" data-remodal-target="time-and-date-stop-modal" type="text" class="form-control" style="direction: rtl" placeholder="تاریخ و ساعت پایان" disabled>
                                                <button data-input-id="setDateStop" data-remodal-target="time-and-date-stop-modal" class="toggle-editable-btn btn btn-circle btn-outline-light"><i
                                                        class="ri-ball-pen-fill"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">هزینه</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-1">
                                            <div data-editable="true" class="fs-7 text-dark">توضیحات</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input id="desc" type="text" class="form-control" style="direction: rtl" placeholder="توضیحات">
                                                <button data-input-id="desc" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-1">
                                            <div  class="fs-7 text-dark">قیمت به تومان</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="price" onkeypress="return isNumber(event)" type="text" class="form-control" style="direction: rtl" placeholder="قیمت به تومان">
                                                <button data-input-id="price" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-1">
                                            <div class="fs-7 text-dark">ظرفیت</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="capacity" onkeypress="return isNumber(event)" type="text" class="form-control" style="direction: rtl" placeholder="ظرفیت">
                                                <button data-input-id="capacity" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">اطلاعات تماس</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-1">
                                            <div  class="fs-7 text-dark">وب سایت</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="site" type="url" class="form-control" style="direction: rtl" placeholder=" به عنوان مثال: http://www.site.ir حتما http را وارد کنید">
                                                <button data-input-id="site" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            {{-- <div class="fs-12 fw-bold text-muted">http را حتما بنویسید</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-1">
                                            <div  class="fs-7 text-dark">پست الکترونیک</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="email" onkeypress="return isEmail(event) || isNumber(event)" type="email" class="form-control" style="direction: rtl" placeholder="پست الکترونیک">
                                                <button data-input-id="email" class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="py-1">
                                            <div  class="fs-7 text-dark">تلفن</div>
                                            <div class="d-flex align-items-center justify-content-between position-relative">
                                                <input onkeypress="return isNumber(event)" minlength="7" maxlength="11" id="launcherPhone" type="text" class="form-control setEnter" style="direction: rtl" placeholder="تلفن">
                                                @include('event.layouts.lock', ['id' => 'launcherPhone'])
                                            </div>
                                            <div id="addTell" class="d-flex gap15 mt-1"></div>
                                            <div class="fontSize14 colorBlack">در صورت وجود بیش از یک تلفن، آن ها را با فاصله از هم جدا نمایید.همچنین پیش شماره کشور و شهر نیز وارد شود. مانند +982111111111</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="spaceBetween mb-2">
                            <a href="{{ route('show-events') }}" class="px-5 b-0 btnHover backColorWhite colorBlack fontSize18">انصراف</a>
                            @if(isset($id))
                                <button data-remodal-target="modalAreYouSure" class="btn btn-sm btn-primary px-5 confrimFormHaveData">اعمال تغییرات</button>
                                <button class="btn btn-sm btn-primary px-5 confrimFormEmpty nextBtn">ثبت اطلاعات</button>
                            @else
                                <button class="btn btn-sm btn-primary px-5 nextBtn">ثبت اطلاعات</button>
                            @endif
                        </div>
                        @if(isset($id))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('addGalleryToEvent', ['event' => $id]) }}" class="colorBlue fontSize14 ml-33 confrimFormHaveData">مشاهده مرحله بعد</a>
                            </div>
                        @endif
                    </div>
                    </div>
            </div>
        </div>
        @include('event.layouts.areYouSureChange')
    </main>
        <!-- start of personal-info-fullname-modal -->
            <div class="remodal remodal-xs" data-remodal-id="time-and-date-start-modal"
                data-remodal-options="hashTracking: false">
                <div class="remodal-header">
                    <div class="remodal-title">تاریخ و ساعت شروع</div>
                    <button data-remodal-action="close" class="remodal-close"></button>
                </div>
                <div class="remodal-content">
                    <div>
                        <div id="date_btn_start_edit" class="label fs-7 font600">تاریخ شروع</div>
                        <label class="tripCalenderSection w-100">
                            <span class="calendarIcon"></span>
                            <input id="date_input_start" class="tripDateInput w-100 form-control directionLtr backColorWhite" placeholder="14XX/XX/XX" required readonly type="text">
                        </label>
                    </div>
                    <div class="form-element-row">
                        <label class="label fs-7">زمان شروع</label>
                        <input id="time_start" type="text" data-clear-btn="true" class="form-control" placeholder="0:00">
                    </div>
                </div>
                <div class="remodal-footer">
                    <button id="startSessionBtn" class="btn btn-sm btn-primary px-3">ثبت اطلاعات</button>
                </div>
            </div>
        <!-- end of personal-info-fullname-modal -->
        <!-- start of personal-info-fullname-modal -->
            <div class="remodal remodal-xs" data-remodal-id="time-and-date-stop-modal"
                data-remodal-options="hashTracking: false">
                <div class="remodal-header">
                    <div class="label fs-7">تاریخ و ساعت پایان</div>
                    <button data-remodal-action="close" class="remodal-close"></button>
                </div>
                <div class="remodal-content">
                    <div class="form-element-row mb-3">
                        <label class="label fs-7 font600">تاریخ پایان</label>
                        <label class="tripCalenderSection w-100">
                            <span class="calendarIcon"></span>
                            <input id="date_input_stop" class="tripDateInput w-100 form-control directionLtr backColorWhite" placeholder="14XX/XX/XX" required readonly type="text">
                        </label>
                    </div>
                    <div class="form-element-row">
                        <label class="label fs-7">زمان پایان</label>
                        <input id="time_stop" type="text" class="form-control" placeholder="0:00">
                    </div>
                </div>
                <div class="remodal-footer">
                    <button id="stopSessionBtn" class="btn btn-sm btn-primary px-3">ثبت اطلاعات</button>
                </div>
            </div>
        <!-- end of personal-info-fullname-modal -->
    <input id="date_input_start_formatted" type="hidden" />
    <input id="date_input_stop_formatted" type="hidden" />

@stop

@section('extraJS')
    @parent
    <script> 
        var timeStart = '';
        var dateStart = '';
        var timeStop = '';
        var dateStop = '';
        var telsObj = {
            tels: [],
            idx: 1
        };

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
        $(document).ready(function(){
            
            $('#time_start').bootstrapMaterialDatePicker({ date: false, time: true, format: 'HH:mm' });
            $('#time_stop').bootstrapMaterialDatePicker({ date: false, time: true, format: 'HH:mm' });
            $("#date_input_start").datepicker(datePickerOptions);
            $("#date_input_stop").datepicker(datePickerOptionsEnd);
            
            watchEnterInTellInput(telsObj);

            $(document).on('click', "#startSessionBtn", function () {
                timeStart =$('#time_start').val();
                dateStart = $('#date_input_start_formatted').val();
                let dateStart2 = $('#date_input_start').val();
                if (timeStart.length == 0 || dateStart.length == 0){
                    showErr("تاریخ شروع و زمان شروع را وارد کنید");
                    return;
                }else{
                    $('#setDateStart').val(timeStart + ' ' + dateStart2);                
                    $(".remodal-close").click();
                }
            });
            $(document).on('click', "#stopSessionBtn", function () {
                timeStop = $('#time_stop').val();
                dateStop = $('#date_input_stop_formatted').val();
                dateStop2 = $('#date_input_stop').val();
                if (timeStop.length == 0 || dateStop.length == 0){
                    showErr("تاریخ پایان و زمان پایان را وارد کنید");
                    return;
                }else{
                    $('#setDateStop').val(timeStop + ' ' + dateStop2);
                    $(".remodal-close").click();               
                }            
            });

            $('#shimmer').removeClass('hidden');
            $('#hiddenHandler').addClass('hidden');

            $.ajax({
                type: 'get',
                url: '{{ route('event.getPhase2Info',['event' => $id]) }}',
                headers: {
                 'accept': 'application/json'
                },
                success: function(res) {

                    if (res.data.mode == "edit"){
                        $(".confrimFormEmpty").addClass("hidden");
                        $(".confrimFormHaveData").removeClass("hidden");
                    }else {
                        $(".confrimFormEmpty").removeClass("hidden");
                        $(".confrimFormHaveData").addClass("hidden");     
                    }
                    
                    if(res.data.start_registry_time.length > 0)
                        $('#time_start').val(res.data.start_registry_time);
                        
                    if(res.data.start_registry_date.length > 0) {
                        $('#date_input_start').val(res.data.start_registry_date_formatted);
                        $('#date_input_start_formatted').val(res.data.start_registry_date);
                    }
                    
                    if(res.data.start_registry_time.length > 0)
                        $('#time_stop').val(res.data.end_registry_time);
                        
                    if(res.data.start_registry_date.length > 0) {
                        $('#date_input_stop').val(res.data.end_registry_date_formatted);
                        $('#date_input_stop_formatted').val(res.data.end_registry_date);
                    }

                    if (res.start_registry_time != undefined && res.data.start_registry_date != undefined || res.data.end_registry_time != undefined && res.data.end_registry_date != undefined ){
                        
                        if(res.data.start_registry_date.length > 0 && res.data.start_registry_date.length > 0){
                            $('#setDateStart').val(res.data.start_registry);
                        }
                        if(res.data.end_registry_date.length > 0 && res.data.end_registry_time.length > 0){
                            $('#setDateStop').val(res.data.end_registry);
                        }
                    }

                    $('#desc').val(res.data.ticket_description);
                    $('#price').val(res.data.price);
                    $('#capacity').val(res.data.capacity);
                    $('#site').val(res.data.site);
                    $('#email').val(res.data.email);
                    if (res.data.phone != undefined){
                        
                        var html = '';
                        let tels = [];
                        let idx = 1;

                        for(i = 0; i < res.data.phone.length; i++ ){
                            tels.push({
                                id: idx,
                                val: res.data.phone[i]
                            });
                            html += '<div id="tel-modal-' + idx + '" class="item-button spaceBetween colorBlack">' + res.data.phone[i] + '';
                            html += '<button class="btn btn-outline-light borderRadius50 marginLeft3">';
                            html += '<i data-id="' + idx + '" class="remove-tel-btn ri-close-line"></i>';
                            html += '</button>';
                            html += '</div>';
                            idx++;
                        }

                        $("#launcherPhone").attr('data-val', tels.map(elem => {return elem.val}).join('-'));
                        $("#addTell").append(html);
                        telsObj.tels = tels;
                        telsObj.idx = idx;
                    }
                    
                    $("#setDateStart").attr("data-editable", "true").removeAttr("disabled");
                    $("#setDateStop").attr("data-editable", "true").removeAttr("disabled");
                    $("#date_input_start").attr("data-editable", "true").removeAttr("disabled");
                    $("#time_start").attr("data-editable", "true").removeAttr("disabled");
                    $("#date_input_stop").attr("data-editable", "true").removeAttr("disabled");
                    $("#time_stop").attr("data-editable", "true").removeAttr("disabled");

                    removeShimmer();
                }
            });
        });
        
        $('.nextBtn').on('click',function() {

            var desc = $('#desc').val();
            var price = $('#price').val();
            var capacity = $('#capacity').val();
            var site = $('#site').val();
            var email = $('#email').val();
            var date_input_start = $('#date_input_start_formatted').val();
            var time_start = $('#time_start').val();
            var date_input_stop = $('#date_input_stop_formatted').val();
            var time_stop = $('#time_stop').val();

            var required_list = ['price','setDateStart','setDateStop'];
            var inputList = checkInputs(required_list);

            if( !inputList ) {
                showErr("همه فیلد ها را پر کنید.");
                return
            }

            $.ajax({
                type: 'post',
                url: '{{ route('event.store_phase2',['event' => $id]) }}',
                data: {
                    'start_registry_date': date_input_start,
                    'start_registry_time': time_start,
                    'end_registry_date': date_input_stop,
                    'end_registry_time': time_stop,
                    'price': price,
                    'ticket_description' : desc,
                    'capacity': capacity,
                    'site': site,
                    'email': email,
                    'phone_arr': telsObj.tels.map((elem, index) => {
                        return elem.val;
                    }),
                },
                success: function(res) {
                    if(res.status === "ok") {
                        showSuccess('با موفقیت ثبت شد .');
                        window.location.href = '{{route('addGalleryToEvent', ['event' => $id]) }}';
                    }else{
                        showErr(res.msg);
                    }
                }
            });
        });
             
    </script>
@stop