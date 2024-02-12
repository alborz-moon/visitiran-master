@extends('layouts.structure')
@section('header')
    @parent
    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.js"></script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('theme-assets/css/createEvent.css') }}" />
    <script>
        var initialing = false;
        var GET_CITIES_URL = '{{ route('api.cities') }}';
    </script>
@stop
@section('content')
    <main class="page-content TopParentBannerMoveOnTop">
        <div class="container">
            <div class="row mb-5">

                @if (!isset($launchers))
                    @include('event.launcher.launcher-menu')
                @endif

                <div class="{{ isset($launchers) ? 'col-xl-12 col-lg-12 col-md-12' : 'col-xl-9 col-lg-8 col-md-7' }}">

                    <div class="d-flex spaceBetween align-items-center">
                        <span
                            class="colorBlack  fontSize15 bold d-none d-md-block">{{ $mode == 'create' ? 'ایجاد رویداد ' : 'ویرایش رویداد' }}</span>
                        <ul class="checkout-steps mt-4 mb-3 w-100">
                            <li class="checkout-step-active">
                                <a href="{{ route('create-event') }}"><span class="checkout-step-title"
                                        data-title="اطلاعات کلی"></span></a>
                            </li>
                            <li>
                                <a
                                    href="{{ isset($id) ? route('addSessionsInfo', ['event' => $id]) : route('addSessionsInfo') }}">
                                    <span class="checkout-step-title" data-title="زمان برگزاری"></span>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ isset($id) ? route('addPhase2Info', ['event' => $id]) : route('addPhase2Info') }}">
                                    <span class="checkout-step-title" data-title="ثبت نام و تماس"></span>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ isset($id) ? route('addGalleryToEvent', ['event' => $id]) : route('addGalleryToEvent') }}">
                                    <span class="checkout-step-title" data-title="اطلاعات تکمیلی"></span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    @include('event.layouts.shimmer')

                    @if (isset($launchers) && !isset($id))
                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">اطلاعات کلی</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">نام برگزار کننده</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select id="launcher" class="select2 w-100">
                                                    <option value="0">انتخاب کنید</option>
                                                    @foreach ($launchers as $launcher)
                                                        <option value="{{ $launcher['id'] }}">
                                                            {{ $launcher['company_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="hiddenHandler"
                        class="{{ isset($id) || isset($launchers) ? 'hidden' : '' }} {{ isset($launchers) && !isset($id) ? 'hideBeforeSearchLauncher' : '' }} ">

                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">اطلاعات کلی</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">نام رویداد</div>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="eventName" type="text"
                                                    class="form-control" style="direction: rtl" placeholder="نام رویداد">
                                                <button data-input-id="eventName"
                                                    class="toggle-editable-btn btn btn-circle btn-outline-light"><i
                                                        class="ri-ball-pen-fill"></i></button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">شرایط سنی</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select id="ageCondi" class="select2 w-100">
                                                    <option value="all" selected>همه سنین</option>
                                                    <option value="child">کودکان تا ۱۰ سال</option>
                                                    <option value="teen">نوجوانان ۱۰ تا ۱۸ سال</option>
                                                    <option value="adult">بزرگسال</option>
                                                    <option value="old">بازنشستگان</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">سطح برگزاری</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select id="level" class="select2 w-100">
                                                    <option value="0">انتخاب کنید</option>
                                                    <option value="national">ملی</option>
                                                    <option value="state">استانی</option>
                                                    <option value="local">محلی</option>
                                                    <option value="pro">تخصصی</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">موضوع</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select class="select2 w-100" name="" id="topicEvent">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex flexWrap gap15 mt-2 flexWrap" id="addTopic">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">زبان</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select class="select2 w-100" name="" id="lang">
                                                    <option value="0" selected>انتخاب کنید</option>
                                                    <option value="fa">فارسی</option>
                                                    <option value="tr">ترکی</option>
                                                    <option value="en">انگلیسی</option>
                                                    <option value="fr">فرانسه</option>
                                                    <option value="gr">آلمانی</option>
                                                    <option value="ar">عربی</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="addLang" class="d-flex gap15 mt-2 flexWrap">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">امکانات ویژه
                                <span class="fontSize12 mx-2 fontNormal">
                                    از موارد زیر انتخاب کنید
                                </span>
                            </div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="py-2">
                                            <div class="tabs gap10" id="facility">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">نوع برگزاری</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="py-2">
                                            <div class="fs-7 text-dark">نوع رویداد</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <select id="onlineOrOffline" class="selectStyle select2">
                                                    <option value="0" selected>انتخاب کنید</option>
                                                    <option value="online">آنلاین</option>
                                                    <option value="offline">آفلاین</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui-box bg-white mb-5 boxShadow hidden_all_fields">
                            <div class="ui-box-title">اطلاعات رویداد</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3 hidden_online_fields">
                                        <!-- start of form-element -->
                                        <div class="form-element-row">
                                            <label class="label fs-7">استان</label>

                                            <select onchange="initialing ? a = 1 : getCities($(this).val())"
                                                class="select2" name="state02" id="state02">
                                                <option value="0">انتخاب کنید</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- end of form-element -->
                                    </div>
                                    <div id="ha" class="col-lg-6 mb-3 hidden_online_fields">
                                        <!-- start of form-element -->
                                        <div class="form-element-row">
                                            <div class="form-element-row">
                                                <label class="label fs-7">شهر</label>
                                                <select class="select2 launcherCityID" name="city02" id="city02">
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end of form-element -->
                                    </div>
                                    <div class="col-lg-6 mb-3 hidden_online_fields">
                                        <div class="py-1">
                                            <div class="fs-7 text-dark">کد پستی</div>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="postalCode"
                                                    onkeypress="return isNumber(event)" minlength="10" maxlength="10"
                                                    type="text" class="form-control" style="direction: rtl"
                                                    placeholder="کد پستی">
                                                <button data-input-id="postalCode"
                                                    class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                            <div class="fs-6 fw-bold text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3 hidden_url_fields hidden">
                                        <div class="py-1">
                                            <div class="fs-7 text-dark">لینک جلسه مجازی</div>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <input data-editable="true" id="link" type="url"
                                                    class="form-control" style="direction: rtl"
                                                    placeholder=" به عنوان مثال: http://www.site.ir حتما http را وارد کنید">
                                                <button data-input-id="link"
                                                    class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="py-1 hidden_online_fields hidden">
                                            <div class="fs-7 text-dark">آدرس</div>
                                            <div
                                                class="d-flex align-items-center justify-content-between position-relative">
                                                <textarea data-editable="true" id="address" type="text" class="form-control" style="direction: rtl"
                                                    placeholder="آدرس"></textarea>
                                                <button data-input-id="address"
                                                    class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                    <i class="ri-ball-pen-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3 hidden_map_fields">
                                        <div class="py-1">
                                            <div class="fs-7 text-dark">نقشه</div>
                                            <div id="launchermap" style="width: 100%; height: 250px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="spaceBetween mb-2">
                            <button onclick="document.location.href = '{{ route('show-events') }}'"
                                class="px-5 b-0 btnHover backColorWhite colorBlack fontSize18">انصراف</button>
                            @if (isset($id))
                                <button data-remodal-target="modalAreYouSure" class="btn btn-sm btn-primary px-5">اعمال
                                    تغییرات</button>
                            @else
                                <button class="btn btn-sm btn-primary px-5 nextBtn">ثبت اطلاعات</button>
                            @endif

                        </div>

                        @if (isset($id))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('addSessionsInfo', ['event' => $id]) }}"
                                    class="colorBlue fontSize14 ml-33">مشاهده مرحله بعد</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @include('event.layouts.areYouSureChange')

    </main>

@stop

@section('extraJS')
    @parent

    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.js">
    </script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.css"
        rel="stylesheet" />
    <script src="{{ asset('theme-assets/js/Utilities.js') }}"></script>
    <script>
        var topic_arr = [];
        var lang_arr = [{
                key: "fa",
                value: "فارسی"
            },
            {
                key: "tr",
                value: "ترکی"
            },
            {
                key: "en",
                value: "انگلیسی"
            },
            {
                key: "fr",
                value: "فرانسه"
            },
            {
                key: "gr",
                value: "آلمانی"
            },
            {
                key: "ar",
                value: "عربی"
            },
        ];

        var map = undefined;
        let loc = {
            x: undefined,
            y: undefined
        };
        var topicList = [];
        var langList = [];
        var onlineOrOffline;
        var idxTopic = 1;
        var idx = 1;
        var facilitiesList = undefined;
        var tagsList = undefined;


        $("#launcher").on('change', function() {

            let launcher = $(this).val();

            $('#shimmer').removeClass('hidden');
            $('#hiddenHandler').addClass('hidden');

            $.ajax({
                type: 'get',
                url: "{{ route('getPlaceInfo') }}" + "/" + launcher,
                success: function(res) {
                    if (res.status === 'ok') {
                        $("#address").val(res.data.address);
                        $("#postalCode").val(res.data.postal_code);
                        $("#state02").val(res.data.state_id).change();
                        getCities(res.data.state_id, res.data.city_id);
                        loc.y = res.data.y;
                        loc.x = res.data.x;
                        $("#hiddenHandler").removeClass('hideBeforeSearchLauncher');
                        removeShimmer();
                    } else
                        showErr(res.msg);
                }
            });
        });


        $(document).ready(function() {
            $('#onlineOrOffline').val(0).change();
            $(".toggle-editable-btn").on("click", function() {
                let id = $(this).attr("data-input-id");
                if ($("#" + id).attr("data-editable") == "true") {
                    $("#" + id).val("");
                }
            });
        });

        function watchList(selectorId, arr, increamentor, elemId, resultPaneId) {

            $('#' + selectorId).on('change', function() {
                var wantedElem = $('#' + selectorId).val();

                let tmp = arr.find((elem, index) => {
                    return elem.value == wantedElem;
                });

                if (tmp !== undefined)
                    return;

                let wantedElemCaption = $('#' + selectorId + ' option:selected').text();

                if (wantedElem != 0) {

                    increamentor++;
                    arr.push({
                        id: increamentor,
                        value: wantedElem
                    });

                    var html = '<div id="' + elemId + '-' + increamentor +
                        '" class="item-button spaceBetween colorBlack">' + wantedElemCaption + '';
                    html += '<button data-id="' + increamentor + '" class="remove-' + elemId +
                        '-btn btn btn-outline-light borderRadius50 marginLeft3 b-0">';
                    html += '<i class="ri-close-line"></i>'
                    html += '</button></div>';

                    $('#' + resultPaneId).append(html);
                    setTimeout(() => {
                        $('#' + selectorId).val("0").change();
                    }, 500);
                }
            });
            $(document).on('click', '.remove-' + elemId + '-btn', function() {
                let id = $(this).attr('data-id');
                arr = arr.filter((elem, index) => {
                    return elem.id != id;
                });
                $("#" + elemId + "-" + id).remove();
            });
        }

        @if (!isset($id))
            $(document).ready(function() {
                watchList('topicEvent', topicList, idxTopic, 'topic', 'addTopic');
                watchList('lang', langList, idx, 'lang', 'addLang');
            });
        @endif

        $('#onlineOrOffline').on('change', function() {
            onlineOrOffline = $('#onlineOrOffline').val();

            if (map === undefined && onlineOrOffline === "offline")
                map = createMap("launchermap", loc);

            if (onlineOrOffline === '0') {
                $(".hidden_all_fields").addClass('hidden');
            } else if (onlineOrOffline === 'online') {
                $(".hidden_all_fields").removeClass('hidden');
                $(".hidden_url_fields").removeClass('hidden');
                $(".hidden_online_fields").addClass('hidden');
                $(".hidden_map_fields").addClass('hidden');
            } else if (onlineOrOffline === 'offline') {
                $(".hidden_address_fields").removeClass('hidden');
                $(".hidden_all_fields").removeClass('hidden');
                $(".hidden_online_fields").removeClass('hidden');
                $(".hidden_url_fields").addClass('hidden');
                $(".hidden_map_fields").removeClass('hidden');
            }
        });

        $.ajax({
            type: 'get',
            url: '{{ url('api/eventTags/list ') }}',
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {

                if (res.status === "ok") {

                    var eventTag = "";
                    tagsList = res.data;

                    if (res.data.length != 0) {
                        eventTag += '<option value="0">انتخاب کنید</option>';

                        for (var i = 0; i < res.data.length; i++)
                            eventTag += '<option name="eventTag" value="' + res.data[i].id + '">' + res.data[i]
                            .label + '</option>';
                        $("#topicEvent").empty().append(eventTag);
                    }

                }
            }
        });

        $.ajax({
            type: 'get',
            url: "{{ route('facilities.show') }}",
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {

                if (res.status === "ok") {

                    facilitiesList = res.data;

                    if (res.data.length != 0) {

                        var facility = "";
                        for (var i = 0; i < res.data.length; i++) {
                            facility += '<input type="checkbox" name="facility" id="' + res.data[i].id + '">';
                            facility += '<label for="' + res.data[i].id + '" class="ml-0">' + res.data[i]
                                .label +
                                '</label>';
                        }
                        $("#facility").empty().append(facility);
                    }
                }
            }
        });

        $(".nextBtn").on('click', function() {
            var eventName = $('#eventName').val();
            var ageCondi = $('#ageCondi').val();
            var level = $('#level').val();
            var state = $('#state02').val();
            var city = $('#city02').val();
            var postalCode = $('#postalCode').val();
            var address = $('#address').val();
            var link = $('#link').val();
            var launcher = undefined;

            if ($('#launcher').length)
                launcher = $('#launcher').val();

            var selectedFacility = [];

            $('input[name=facility]').each(function() {
                if ($(this).is(":checked")) {
                    selectedFacility.push($(this).attr('id'));
                }
            });

            var required_list = (onlineOrOffline == "offline") ? ['postalCode', 'eventName'] : ['eventName',
                'link'
            ];
            var required_list_Select = (onlineOrOffline == "offline") ? ['level', 'state02', 'city02',
                'onlineOrOffline'
            ] : ['level', 'onlineOrOffline'];
            var required_Arr = ['topicEvent', 'lang'];
            var Arr = [topicList, langList];

            var inputList = checkInputs(required_list);
            var selectList = checkSelect(required_list_Select);
            var selectAddBox = checkArr(required_Arr, Arr);

            if (!inputList || !selectList || !selectAddBox) {
                showErr("همه فیلد ها را پر کنید.")
                return;
            }

            let data = {
                title: eventName,
                facilities_arr: selectedFacility,
                tags_arr: topicList.map((elem, index) => {
                    return elem.value;
                }),
                language_arr: langList.map((elem, index) => {
                    return elem.value;
                }),
                age_description: ageCondi,
                level_description: level,
                type: onlineOrOffline,
            };
            if (onlineOrOffline == "offline") {
                data.city_id = city;
                data.postal_code = postalCode;
                data.address = address;
                data.x = loc.x;
                data.y = loc.y;
            } else if (onlineOrOffline == "online") {
                data.link = link;
            }
            if (launcher != undefined) {
                data.launcher_id = launcher;
            }
            $.ajax({
                type: 'post',
                url: "{{ isset($id) ? route('event.update', ['event' => $id]) : route('event.store') }}",
                data: data,
                success: function(res) {
                    if (res.status === "ok") {

                        showSuccess("عملیات موردنظر با موفقیت انجام شد.");

                        @if (isset($id))
                            window.location.href = "{{ route('addSessionsInfo', ['event' => $id]) }}";
                        @else
                            window.location.href = "{{ route('addSessionsInfo') }}" + "/" + res.id;
                        @endif

                    } else {
                        alert(res.msg);
                    }
                }
            });

        });

        @if (isset($id))

            function checkFetchData() {

                if (tagsList === undefined || facilitiesList === undefined)
                    setTimeout(checkFetchData, 500);
                else
                    getPhase1Info();
            }

            setTimeout(checkFetchData, 500);


            function getPhase1Info() {

                $('#shimmer').removeClass('hidden');
                $('#hiddenHandler').addClass('hidden');

                $.ajax({
                    type: 'get',
                    url: "{{ route('event.getPhase1Info', ['event' => $id]) }}",
                    headers: {
                        'accept': 'application/json'
                    },
                    success: function(res) {

                        if (res.status === "ok" && res.data.length != 0) {

                            $('input').attr("data-editable", "false");
                            $('textarea').attr("data-editable", "false");
                            $('.toggle-editable-btn').removeClass('hidden');
                            $('#eventName').val(res.data.title);
                            $('#ageCondi').val(res.data.age_description).change();
                            $('#level').val(res.data.level_description).change();

                            if (res.data.type === "offline") {
                                initialing = true;
                                loc.x = res.data.x;
                                loc.y = res.data.y;
                                $('#state02').val(res.data.state_id).change();
                                $('#address').val(res.data.address);
                                $('#postalCode').val(res.data.postal_code);
                                getCities(res.data.state_id, res.data.city_id);
                            } else {
                                $('#link').val(res.data.link);
                            }

                            $('#onlineOrOffline').val(res.data.type).change();

                            @if (isset($launchers))
                                $('#launcher').val(res.data.launcher.id).change();
                            @endif

                            var language = '';
                            if (res.data.language.length != 0) {
                                for (var i = 0; i < res.data.language.length; i++) {
                                    let elem = lang_arr.find(itr => itr.key == res.data.language[i]);
                                    language += '<div id="lang-' + idx +
                                        '" class="item-button spaceBetween colorBlack">' + elem.value + '';
                                    language += '<button data-id="' + idx +
                                        '" class="remove-lang-btn btn btn-outline-light borderRadius50 marginLeft3 b-0">';
                                    language += '<i class="ri-close-line"></i>';
                                    language += '</button></div>';

                                    langList.push({
                                        id: idx,
                                        value: elem.key
                                    });
                                }
                                idx = res.data.language.length + 1;
                                $("#addLang").append(language);
                            }
                            var tags = '';
                            if (res.data.tags.length != 0) {
                                for (var i = 0; i < res.data.tags.length; i++) {

                                    let elem = tagsList.find(itr => itr.label == res.data.tags[i]);

                                    if (elem === undefined)
                                        continue;

                                    tags += '<div id="topic-' + elem.id +
                                        '" class="item-button spaceBetween colorBlack">' + res.data.tags[i] +
                                        '';
                                    tags += '<button data-id="' + elem.id +
                                        '" class="remove-topic-btn remove-' +
                                        elem.id + '-btn btn btn-outline-light borderRadius50 marginLeft3 b-0">';
                                    tags += '<i class="ri-close-line"></i>';
                                    tags += '</button></div>';

                                    topicList.push({
                                        id: elem.id,
                                        value: elem.id
                                    });
                                }
                                idxTopic = res.data.tags.length + 1;
                                $("#addTopic").append(tags);
                            }

                            watchList('topicEvent', topicList, idxTopic, 'topic', 'addTopic');
                            watchList('lang', langList, idx, 'lang', 'addLang');

                            if (res.data.facilities.length != 0) {
                                for (var i = 0; i < res.data.facilities.length; i++) {

                                    let elem = facilitiesList.find(itr => itr.label == res.data.facilities[i]);
                                    if (elem !== undefined)
                                        $("input[name='facility'][id='" + elem.id + "']").prop('checked', true);

                                }
                            }

                            removeShimmer();

                        }
                    }
                });
            }
        @endif
    </script>
@stop
