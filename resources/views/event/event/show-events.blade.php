@extends('layouts.structure')

@section('header')
    @parent


    <script src="{{ URL::asset('theme-assets/js/moment.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('theme-assets/css/bootstrap-material-datetimepicker.css') }}">
    <script src="{{ URL::asset('theme-assets/js/bootstrap-material-datetimepicker.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('theme-assets/bootstrap-datepicker.css?v=1') }}">
    <script src="{{ URL::asset('theme-assets//bootstrap-datepicker.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('theme-assets/css/show-event.css') }}">

@stop

@section('content')
    <main class="page-content TopParentBannerMoveOnTop">
        <div class="container">
            <div class="row mb-5">
                <div id="nothingToShow" class="hidden">

                    <div style=" height: 180px">
                        <img class=" h-100 " src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
                    </div>

                    <div> موردی برای نمایش موجود نیست</div>

                </div>
                @include('event.launcher.launcher-menu')

                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="ui-box bg-white mb-5 boxShadow p-0">
                        <div class="ui-box-title">رویداد ها</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="py-2">
                                        <div class="tabs">

                                            <input type="radio" name="tabs" id="tabone" checked="checked">
                                            <label for="tabone">پیش نویس</label>
                                            <div class="tab p-0">
                                                <div class="ui-box bg-white mb-5 p-0">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0 marginTop10">
                                                            <thead>
                                                                <tr>
                                                                    <th>شماره</th>
                                                                    <th>نام رویداد </th>
                                                                    <th>اطلاعات کلی</th>
                                                                    <th>اطلاعات برگزاری</th>
                                                                    <th>اطلاعات ثبت نام</th>
                                                                    <th>اطلاعات تکمیلی</th>
                                                                    <th>عملیات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="drafts"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="radio" name="tabs" id="tabtwo">
                                            <label for="tabtwo">در انتظار تایید</label>
                                            <div class="tab p-0">
                                                <div class="ui-box bg-white mb-5 p-0">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0 marginTop10">
                                                            <thead>
                                                                <tr>
                                                                    <th>شماره</th>
                                                                    <th>نام رویداد</th>
                                                                    <th> تاریخ ایجاد </th>
                                                                    <th>وضعیت</th>
                                                                    <th>آخرین بروزرسانی</th>
                                                                    <th>عملیات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="pendings"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="radio" name="tabs" id="tabfour">
                                            <label for="tabfour">در ثبت نام</label>
                                            <div class="tab p-0">
                                                <div class="ui-box bg-white mb-5 p-0">

                                                    <div class="table-responsive dropdown">
                                                        <table class="table mb-0 marginTop10">
                                                            <thead>
                                                                <tr>
                                                                    <th>شماره</th>
                                                                    <th>نام رویداد</th>
                                                                    <th>قیمت</th>
                                                                    <th>ظرفیت</th>
                                                                    <th>تاریخ شروع ثبت نام</th>
                                                                    <th>تاریخ پایان ثبت نام</th>
                                                                    <th>وضعیت نمایش</th>
                                                                    <th>عملیات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="registries"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="radio" name="tabs" id="tabfive">
                                            <label for="tabfive">جاری</label>
                                            <div class="tab p-0">
                                                <div class="ui-box bg-white mb-5 p-0">
                                                    <div class="table-responsive dropdown">
                                                        <table class="table mb-0 marginTop10">
                                                            <thead>
                                                                <tr>
                                                                    <th>شماره</th>
                                                                    <th>نام رویداد</th>
                                                                    <th>تاریخ شروع و پایان دوره</th>
                                                                    <th>قیمت </th>
                                                                    <th>نفرات ثبت نام</th>
                                                                    <th>درآمد</th>
                                                                    <th>عملیات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="runs">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="radio" name="tabs" id="tabsix">
                                            <label for="tabsix">آرشیو</label>
                                            <div class="tab p-0">
                                                <div class="ui-box bg-white mb-5 p-0">
                                                    <div class="table-responsive dropdown">
                                                        <table class="table mb-0 marginTop10">
                                                            <thead>
                                                                <tr>
                                                                    <th>شماره</th>
                                                                    <th>نام رویداد</th>
                                                                    <th>تاریخ شروع و پایان دوره</th>
                                                                    <th>قیمت </th>
                                                                    <th>نفرات ثبت نام</th>
                                                                    <th>درآمد</th>
                                                                    <th>عملیات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="archieves"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- start of personal-info-fullname-modal -->
    <div class="remodal remodal-xs" data-remodal-id="changePriceModal" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">تغییر قیمت</div>
            <button data-remodal-action="close" class="remodal-close"></button>
        </div>
        <div class="remodal-content">
            <div class="form-element-row">
                <label class="label fs-7">قیمت موردنظر</label>
                <input id="newprice" type="text" class="form-control" onkeypress="return isNumber(event)"
                    placeholder="قیمت موردنظر" value="">
            </div>
        </div>
        <div class="remodal-footer">
            <button id="changePrice" class="btn btn-sm btn-primary px-3">ثبت اطلاعات</button>
        </div>
    </div>
    <!-- end of personal-info-fullname-modal -->


    <!-- start of personal-info-fullname-modal -->
    <div class="remodal remodal-xs" data-remodal-id="changeCapacityModal" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">تغییر ظرفیت</div>
            <button data-remodal-action="close" class="remodal-close"></button>
        </div>
        <div class="remodal-content">
            <div class="form-element-row">
                <label class="label fs-7">ظرفیت موردنظر</label>
                <input id="newcapacity" type="text" class="form-control" onkeypress="return isNumber(event)"
                    placeholder="ظرفیت موردنظر" value="">
            </div>
        </div>
        <div class="remodal-footer">
            <button id="changeCapacity" class="btn btn-sm btn-primary px-3">ثبت اطلاعات</button>
        </div>
    </div>
    <!-- end of personal-info-fullname-modal -->

    <button id="show-buyers-list" data-remodal-target="registryList" class="hidden"></button>
    <button id="show-days-list" data-remodal-target="daysList" class="hidden"></button>

    <!-- start of registry-list-modal -->
    <div class="remodal remodal-lg" data-remodal-id="registryList" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">لیست ثبت نام رویداد <span id="registryListEventName"></span></div>
            <button data-remodal-action="close" class="remodal-close"></button>
        </div>
        <div class="remodal-content">

            <button data-remodal-target="addPersonModal" class="btn btn-circle borderCircle my-1">
                <i class="icon-visit-Exclusion1"></i>
            </button>

            <table class="table mb-0 marginTop10">
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>نام</th>
                        <th>کد ملی</th>
                        <th>شماره همراه </th>
                        <th>تعداد</th>
                        <th>مبلغ پرداختی</th>
                        <th>زمان ثبت نام</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="registryListContent"></tbody>
            </table>

        </div>
    </div>
    <!-- end of registry-list-modal -->


    <!-- start of days-list-modal -->
    <div class="remodal remodal-lg" data-remodal-id="daysList" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">لیست روزهای برگزاری رویداد <span id="daysList"></span></div>
            <button data-remodal-action="close" class="remodal-close"></button>
        </div>
        <div class="remodal-content">

            <table class="table mb-0 marginTop10">
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>ساعت شروع</th>
                        <th>ساعت اتمام</th>
                    </tr>
                </thead>
                <tbody id="daysListContent"></tbody>
            </table>

        </div>
    </div>
    <!-- end of days-list-modal -->



    <!-- start of force-registry-modal -->
    <div class="remodal remodal-xs" data-remodal-id="addPersonModal" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">ثبت نام نفر جدید</div>
            <button id="close-add-person-btn" onclick="$('#show-buyers-list').click()" data-remodal-action="close"
                class="remodal-close"></button>
        </div>
        <div class="remodal-content">
            <div class="form-element-row">

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">نام</label>
                    <input id="first_name" type="text" class="form-control" placeholder="نام" value="">
                </div>

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">نام خانوادگی</label>
                    <input id="last_name" type="text" class="form-control" placeholder="نام خانوادگی"
                        value="">
                </div>

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">هزینه پرداختی</label>
                    <input id="paid" type="text" class="form-control" onkeypress="return isNumber(event)"
                        placeholder="هزینه پرداختی" value="">
                </div>

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">کد ملی</label>
                    <input id="nid" type="text" class="form-control" onkeypress="return isNumber(event)"
                        placeholder="کد ملی" value="">
                </div>

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">شماره همراه</label>
                    <input id="phone" type="text" class="form-control" onkeypress="return isNumber(event)"
                        placeholder="شماره همراه" value="">
                </div>

                <div class="col-xs-12 marginTop10">
                    <label class="label fs-7">تعداد</label>
                    <input id="count" type="text" class="form-control" onkeypress="return isNumber(event)"
                        placeholder="تعداد" value="">
                </div>

            </div>
        </div>
        <div class="remodal-footer">
            <button id="addPersonBtn" class="btn btn-sm btn-primary px-3">ثبت اطلاعات</button>
        </div>
    </div>
    <!-- end of force-registry-modal -->

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
                    <input id="date_input_start" class="tripDateInput w-100 form-control directionLtr backColorWhite"
                        placeholder="14XX/XX/XX" required readonly type="text">
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
                    <input id="date_input_stop" class="tripDateInput w-100 form-control directionLtr backColorWhite"
                        placeholder="14XX/XX/XX" required readonly type="text">
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

        let fetched_event_buyers = [];
        let fetched_sessions_buyers = [];

        var datePickerOptions = {
            numberOfMonths: 1,
            showButtonPanel: true,
            dateFormat: "DD d M سال yy",
            altFormat: "yy/mm/dd",
            altField: $("#date_input_start_formatted")
        };

        var datePickerOptionsEnd = {
            numberOfMonths: 1,
            showButtonPanel: true,
            dateFormat: "DD d M سال yy",
            altFormat: "yy/mm/dd",
            altField: $("#date_input_stop_formatted")
        };

        $("#addPersonBtn").on('click', function() {

            let first_name = $("#first_name").val();
            let last_name = $("#last_name").val();
            let nid = $("#nid").val();
            let phone = $("#phone").val();
            let count = $("#count").val();
            let paid = $("#paid").val();

            if (
                first_name.length === 0 || last_name.length === 0 ||
                nid.length === 0 || phone.length === 0 ||
                count.length === 0 || paid.length === 0
            ) {
                showErr('لطفا تمام اطلاعات لازم را پرنمایید');
                return;
            }

            let data = {
                first_name: first_name,
                last_name: last_name,
                nid: nid,
                phone: phone,
                count: count,
                paid: paid
            };

            $.ajax({
                type: 'post',
                url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/buyers",
                data: data,
                success: function(res) {
                    if (res.status === 'ok') {

                        showSuccess('عملیات موردنظر با موفقیت انجام شد');
                        data.id = res.id;
                        data.created_at = res.created_at;

                        $('#registryListContent').append(add_person_to_table(data));
                        $("#close-add-person-btn").click();
                        $("#show-buyers-list").click();
                    }
                }
            });

        });

        $(document).ready(function() {
            $('#time_start').bootstrapMaterialDatePicker({
                date: false,
                time: true,
                format: 'HH:mm'
            });
            $('#time_stop').bootstrapMaterialDatePicker({
                date: false,
                time: true,
                format: 'HH:mm'
            });
            $("#date_input_start").datepicker(datePickerOptions);
            $("#date_input_stop").datepicker(datePickerOptionsEnd);
        });

        let selectedId;

        $(document).on('click', '.changePriceBtn', function() {
            $("#newprice").val($(this).attr('data-val'));
            selectedId = $(this).attr('data-id');
        });

        $(document).on('click', '.changeCapacityBtn', function() {
            $("#newcapacity").val($(this).attr('data-val'));
            selectedId = $(this).attr('data-id');
        });

        $(document).on('click', '.changeStartRegistryBtn', function() {
            $("#date_input_start").val($(this).attr('data-val'));
            selectedId = $(this).attr('data-id');
        });

        $(document).on('click', '.changeEndRegistryBtn', function() {
            $("#date_input_stop").val($(this).attr('data-val'));
            selectedId = $(this).attr('data-id');
        });

        $(document).on('click', '.buyersListBtn', function() {
            selectedId = $(this).attr('data-id');
            buyersList();
        });

        $(document).on('click', '.sessionsListBtn', function() {
            selectedId = $(this).attr('data-id');
            daysList();
        });

        $(document).on('click', '.changeVisibility', function() {
            selectedId = $(this).attr('data-id');
            changeVisibility($(this).attr('data-val'));
        });

        function update(key) {

            let val = $("#new" + key).val();
            let data = {};
            data[key] = val;

            $.ajax({
                type: 'put',
                url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/launcher-update",
                data: data,
                success: function(res) {

                    if (res.status === 'ok') {
                        $("#" + key + "_" + selectedId).empty().append(val);
                        $("#" + key + "_" + selectedId + "_btn").attr('data-val', val);
                        $(".remodal-close").click();
                    }

                }
            });

        }


        function add_person_to_table(data) {

            var elem = '<tr>';
            elem += '<td>' + personsIdx + '</td>';
            elem += '<td>' + data.first_name + ' ' + data.last_name + '</td>';
            elem += '<td>' + data.nid + '</td>';
            elem += '<td>' + data.phone + '</td>';
            elem += '<td>' + data.count + '</td>';
            elem += '<td>' + data.paid + '</td>';
            elem += '<td>' + data.created_at + '</td>';


            elem += '<td>';
            elem += '<a href="' + '{{ route('event.home') }}' + '/recp/' + data
                .id + '" download class="btn btn-circle changeEndRegistryBtn borderCircle my-1">';
            elem += '<i class="icon-visit-open"></i>';
            elem += '</a>';
            elem += '</td>';


            elem += '</tr>';
            return elem;
        }

        function add_buyers_to_table(data) {

            personsIdx = 1;
            let html = '';

            for (let i = 0; i < data.length; i++)
                html += add_person_to_table(data[i]);

            $('#registryListContent').empty().append(html);
            $("#show-buyers-list").click();

        }

        function buyersList() {

            let buyers = fetched_event_buyers.find(elem => elem.id === selectedId);
            if (buyers !== undefined) {
                add_buyers_to_table(buyers.data);
                return;
            }

            $.ajax({
                type: 'get',
                url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/buyers",
                success: function(res) {

                    if (res.status === 'ok') {
                        fetched_event_buyers.push({
                            id: selectedId,
                            data: res.data
                        });
                        add_buyers_to_table(res.data);
                    }

                }
            });

        }

        function add_sessions_to_table(data) {

            sessionsIdx = 1;
            let html = '';

            for (let i = 0; i < data.length; i++) {
                html += '<tr>';
                html += '<td>' + sessionsIdx + '</td>';
                html += '<td>' + data[i].start + '</td>';
                html += '<td>' + data[i].end + '</td>';
                html += '</tr>';
                sessionsIdx++;
            }

            $('#daysListContent').empty().append(html);
            $("#show-days-list").click();
        }


        function daysList() {

            let days = fetched_sessions_buyers.find(elem => elem.id === selectedId);
            if (days !== undefined) {
                add_sessions_to_table(days);
                return;
            }

            $.ajax({
                type: 'get',
                url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/sessions",
                success: function(res) {

                    if (res.status === 'ok') {
                        fetched_sessions_buyers.push({
                            id: selectedId,
                            data: res.data
                        });
                        add_sessions_to_table(res.data);
                    }

                }
            });

        }


        function changeVisibility(newStatus) {

            $.ajax({
                type: 'put',
                url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/launcher-update",
                data: {
                    visibility: newStatus
                },
                success: function(res) {

                    if (res.status === 'ok') {
                        showSuccess('عملیات موردنظر با موفقیت انجام شد');
                        $(".changeVisibility_" + selectedId)
                            .empty().append(newStatus == '1' ? 'عدم نمایش' : 'نمایش')
                            .attr('data-val', newStatus == '1' ? '0' : '1');
                        $(".visibility_" + selectedId)
                            .empty().append(newStatus == '1' ? 'نمایش' : 'عدم نمایش');
                    }

                }
            });

        }

        $(document).on('click', '#changePrice', function() {
            update("price");
        });

        $(document).on('click', '#changeCapacity', function() {
            update("capacity");
        });

        $(document).on('click', '#startSessionBtn', function() {

            timeStart = $('#time_start').val();
            dateStart = $('#date_input_start_formatted').val();

            let dateStart2 = $('#date_input_start').val();

            if (timeStart.length == 0 || dateStart.length == 0) {
                showErr("تاریخ شروع و زمان شروع را وارد کنید");
                return;
            } else {

                $.ajax({
                    type: 'put',
                    url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/launcher-update",
                    data: {
                        'start_registry_date': dateStart,
                        'start_registry_time': timeStart
                    },
                    success: function(res) {

                        if (res.status === 'ok') {
                            $("#start_registry_" + selectedId).empty().append(dateStart2 + " - " +
                                timeStart);
                            $(".remodal-close").click();
                        }

                    }
                });

            }
        });


        $(document).on('click', '#stopSessionBtn', function() {

            timeStart = $('#time_stop').val();
            dateStart = $('#date_input_stop_formatted').val();

            let dateStart2 = $('#date_input_stop').val();

            if (timeStart.length == 0 || dateStart.length == 0) {
                showErr("تاریخ پایان و زمان پایان را وارد کنید");
                return;
            } else {

                $.ajax({
                    type: 'put',
                    url: '{{ route('event.home') }}' + "/admin/event/" + selectedId + "/launcher-update",
                    data: {
                        'end_registry_date': dateStart,
                        'end_registry_time': timeStart
                    },
                    success: function(res) {

                        if (res.status === 'ok') {
                            $("#end_registry_" + selectedId).empty().append(dateStart2 + " - " +
                                timeStart);
                            $(".remodal-close").click();
                        }

                    }
                });
            }
        });

        let draftsIdx = 1;
        let pendingsIdx = 1;
        let registryIdx = 1;
        let runIdx = 1;
        let archieveIdx = 1;
        let personsIdx = 1;
        let sessionsIdx = 1;

        let steps = ['first', 'second', 'third', 'forth'];
        let updateEvent = '{{ route('event.home') }}' + "/admin/update-event/";
        let links = [
            updateEvent,
            '{{ route('event.home') }}' + "/admin/addSessionsInfo/",
            '{{ route('event.home') }}' + "/admin/addPhase2Info/",
            '{{ route('event.home') }}' + "/admin/addGalleryToEvent/",
        ];



        function addToDrafts(data) {
            let html = '<tr id="row_' + data.id + '">';
            html += '<td>' + draftsIdx + '</td>';
            html += '<td>' + data.title + '</td>';


            if (data.stepsStatus != null) {

                for (let i = 0; i < steps.length; i++) {

                    if (data.stepsStatus[steps[i]] === 'done')
                        html += '<td class="fa-num">تکیمل';
                    else
                        html += '<td class="fa-num">نیازمند تکیمل';

                    html += '<a target="_blank" href="' + links[i] + '' + data.id +
                        '" class="btn btn-circle borderCircle my-1">';
                    html += '<i class="icon-visit-edit"></i>';
                    html += '</a></td>';
                }

            } else
                html += '<td></td><td></td><td></td><td></td>';

            html += '<td>';
            html += '<button data-id="' + data.id + '" class="btn btn-circle borderCircle removeEventBtn my-1">';
            html += '<i class="icon-visit-delete"></i>';
            html += '</button>';
            html += '</td>';

            html += '</tr>';
            draftsIdx++;
            $("#drafts").append(html);
        }

        function addToPending(data) {
            let html = '<tr>';
            html += '<td>' + pendingsIdx + '</td>';
            html += '<td><a href="' + updateEvent + data.id + '">' + data.title + '</a></td>';
            html += '<td>' + data.created_at + '</td>';

            html += '<td class="fa-num">';


            if (data.status === 'pending')
                html += '<span class="badge bg-warning rounded-pill">در حال بررسی </span>';
            else
                html += '<span class="badge bg-danger rounded-pill">رد شده</span>';

            html += '</button>';
            html += '</td>';

            html += '<td>' + data.updated_at + '</td>';

            html += '<td>';
            html += '<button data-id="' + data.id + '" class="btn btn-circle borderCircle removeEventBtn my-1">';
            html += '<i class="icon-visit-delete"></i>';
            html += '</button>';
            html += '</td>';

            html += '</tr>';
            pendingsIdx++;
            $("#pendings").append(html);
        }

        function addToRegistry(data) {

            let html = '<tr>';
            html += '<td>' + registryIdx + '</td>';

            html += '<td>' + data.title + '</td>';

            html += '<td><span id="price_' + data.id + '">' + data.price + '</span>';
            html += '<button id="price_' + data.id + '_btn" data-id="' + data.id +
                '" data-remodal-target="changePriceModal" data-val="' + data.price +
                '" class="btn btn-circle changePriceBtn borderCircle my-1">';
            html += '<i class="icon-visit-edit"></i>';
            html += '</button>';
            html += '</td>';

            html += '<td><span id="capacity_' + data.id + '">' + data.capacity + '</span>';
            html += '<button id="capacity_' + data.id + '_btn" data-id="' + data.id +
                '" data-remodal-target="changeCapacityModal" data-val="' + data.capacity +
                '" class="btn btn-circle changeCapacityBtn borderCircle my-1">';
            html += '<i class="icon-visit-edit"></i>';
            html += '</button>';
            html += '</td>';

            html += '<td><span id="start_registry_' + data.id + '">' + data.start_registry + '</span>';
            html += '<button id="start_registry_' + data.id + '_btn" data-id="' + data.id +
                '" data-remodal-target="time-and-date-start-modal" data-val="' + data.start_registry +
                '" class="btn btn-circle changeStartRegistryBtn borderCircle my-1">';
            html += '<i class="icon-visit-edit"></i>';
            html += '</button>';
            html += '</td>';

            html += '<td><span id="end_registry_' + data.id + '">' + data.end_registry + '</span>';
            html += '<button id="end_registry_' + data.id + '_btn" data-id="' + data.id +
                '" data-remodal-target="time-and-date-stop-modal" data-val="' + data.end_registry +
                '" class="btn btn-circle changeEndRegistryBtn borderCircle my-1">';
            html += '<i class="icon-visit-edit"></i>';
            html += '</button>';
            html += '</td>';

            if (data.visibility == 1)
                html += '<td class="visibility_' + data.id + '">نمایش</td>';
            else
                html += '<td class="visibility_' + data.id + '">عدم نمایش</td>';

            html += '<td>';

            html +=
                '<button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-id="' +
                data.id + '">';
            html += '<i class="icon-visit-menu"></i>';
            html += '</button>';
            html += '<ul class="dropdown-menu">';

            if (data.visibility == 1)
                html += '<li><button data-id="' + data.id + '" data-val="0" class="changeVisibility_' + data.id +
                ' changeVisibility dropdown-item fontSize12 btnHover">عدم نمایش</button></li>';
            else
                html += '<li><button data-id="' + data.id + '" data-val="1" class="changeVisibility_' + data.id +
                ' changeVisibility dropdown-item fontSize12 btnHover">نمایش</button></li>';

            html += '<li><button data-id="' + data.id +
                '" class="buyersListBtn dropdown-item fontSize12 btnHover">لیست ثبت نام</button></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" target="_blank" href="' + updateEvent + data.id +
                '">مشاهده و ویرایش</a></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">گزارش گیری مالی</a></li>';
            html += '<li><button data-id="' + data.id +
                '" class="sessionsListBtn dropdown-item fontSize12 btnHover">مشاهده روزهای برگزاری</button></li>';
            html += '</ul>';
            html += '</td>';

            html += '</tr>';
            registryIdx++;

            $("#registries").append(html);
        }

        function addToRun(data) {

            let html = '<tr>';
            html += '<td>' + runIdx + '</td>';
            html += '<td>' + data.title + '</td>';

            if (data.start !== '' && data.end !== '')
                html += '<td>' + data.start + ' تا ' + data.end + '</td>';
            else
                html += '<td></td>';

            html += '<td>' + data.price + '</td>';
            html += '<td>' + data.buyersCount + '</td>';
            html += '<td>' + data.totalPaid + '</td>';


            html += '<td>';
            html +=
                '<button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-id="' +
                data.id + '">';
            html += '<i class="icon-visit-menu"></i>';
            html += '</button>';
            html += '<ul class="dropdown-menu">';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">گزارش گیری کاربران</a></li>';
            html += '<li><button data-id="' + data.id +
                '" class="sessionsListBtn dropdown-item fontSize12 btnHover">مشاهده روزهای برگزاری</button></li>';

            html += '<li><button data-id="' + data.id +
                '" class="buyersListBtn dropdown-item fontSize12 btnHover">لیست ثبت نام</button></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" target="_blank" href="' + updateEvent + data.id +
                '">مشاهده و ویرایش</a></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">مشاهده</a></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">گزارش گیری مالی</a></li>';
            html += '</ul>';
            html += '</td>';

            html += '</tr>';
            runIdx++;

            $("#runs").append(html);
        }

        function addToArchieve(data) {

            let html = '<tr>';
            html += '<td>' + archieveIdx + '</td>';
            html += '<td>' + data.title + '</td>';

            if (data.start !== '' && data.end !== '')
                html += '<td>' + data.start + ' تا ' + data.end + '</td>';
            else
                html += '<td></td>';

            html += '<td>' + data.price + '</td>';
            html += '<td>' + data.buyersCount + '</td>';
            html += '<td>' + data.totalPaid + '</td>';


            html += '<td>';
            html +=
                '<button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-id="' +
                data.id + '">';



            html += '<i class="icon-visit-menu"></i>';
            html += '</button>';
            html += '<ul class="dropdown-menu">';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">گزارش گیری کاربران</a></li>';
            html += '<li><button data-id="' + data.id +
                '" class="sessionsListBtn dropdown-item fontSize12 btnHover">مشاهده روزهای برگزاری</button></li>';
            html += '<li><button data-id="' + data.id +
                '" class="buyersListBtn dropdown-item fontSize12 btnHover">لیست ثبت نام</button></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" target="_blank" href="' + updateEvent + data.id +
                '">مشاهده</a></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">گزارش گیری مالی</a></li>';
            html += '<li><a class="dropdown-item fontSize12 btnHover" href="#">وضعیت تسویه حساب</a></li>';
            html += '</ul>';
            html += '</td>';

            html += '</tr>';
            archieveIdx++;

            $("#archieves").append(html);
        }


        $(document).on('click', ".removeEventBtn", function() {

            let id = $(this).attr('data-id');

            $.ajax({
                type: 'delete',
                url: '{{ route('event.home') }}' + "/admin/event/" + id,
                success: function(res) {

                    if (res.status === "ok") {
                        showSuccess("عملیات موردنظر با موفقیت انجام شد");
                        $("#row_" + id).remove();
                    }

                }
            });

        });

        $.ajax({
            type: 'get',
            url: '{{ route('myevents') }}',
            success: function(res) {

                if (res.status === 'ok') {

                    for (let i = 0; i < res.data.length; i++) {

                        if (res.data[i].status === 'init')
                            addToDrafts(res.data[i]);
                        else if (res.data[i].status === 'rejected' || res.data[i].status === 'pending')
                            addToPending(res.data[i]);
                        else if (res.data[i].status === 'confirmed' && res.data[i].runStatus === 'registry')
                            addToRegistry(res.data[i]);
                        else if (res.data[i].status === 'confirmed' && res.data[i].runStatus === 'run')
                            addToRun(res.data[i]);
                        else if (res.data[i].status === 'confirmed' && res.data[i].runStatus === 'finish')
                            addToArchieve(res.data[i]);
                    }

                }

            }
        });
    </script>
@stop
