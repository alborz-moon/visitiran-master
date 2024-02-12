@extends('layouts.structure')
@section('header')
    @parent
    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.js"></script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/v1.13.0/mapbox-gl.css" rel="stylesheet" />
    <script>
        let GET_CITIES_URL = '{{ route('api.cities') }}';
    </script>
    <style>
        .searchUserContentHidden {
            display: none;
        }
    </style>
    <script src="{{ asset('theme-assets/js/Utilities.js') }}"></script>
@stop
@section('content')
    <main class="page-content TopParentBannerMoveOnTop">
        <div class="container">
            <div class="row mb-5">
                <?php $isEditor = Auth::user()->isEditor(); ?>
                @if (!$isEditor)
                    @include('event.launcher.launcher-menu')
                @endif
                <div class="{{ $isEditor ? 'col-xl-12 col-lg-12 col-md-12' : 'col-xl-9 col-lg-8 col-md-7' }}">

                    @include('event.layouts.shimmer')

                    <div id="hiddenHandler">
                        @if ($mode == 'create')
                            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center spaceBetween"
                                role="alert">
                                <div>
                                    در خواست ارتقا به برگزار کننده پس از ارسال توسط ادمین بازبینی و تایید خواهد شد .
                                </div>
                            </div>
                        @elseif ($mode == 'edit')
                            @if ($status != 'rejected' && $status != 'confirmed')
                                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center spaceBetween"
                                    role="alert">
                                    <div>
                                        در حال حاضر حساب برگزار کننده شما غیر فعال است. پس از بررسی مدارک و تایید از سوی
                                        ادمین
                                        حساب شما فعال خواهد شد.
                                    </div>
                                    <a href="#" class="btn btn-sm btn-primary mx-3 WhiteSpaceNoWrap">مشاهده سوابق</a>
                                </div>
                            @elseif($status == 'rejected')
                                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center spaceBetween"
                                    role="alert">
                                    <div>
                                        تایید حساب برگزار کننده با مشکل مواجه شده است . برای جزئیات بیشتر به پشتیبانی مراجه
                                        کنید.
                                    </div>
                                    <a href="#" class="btn btn-sm btn-primary mx-3 WhiteSpaceNoWrap">پشتیبانی</a>
                                </div>
                            @endif
                        @endif

                        @if ($isEditor && $mode !== 'edit')
                            <div class="ui-box bg-white mb-5 boxShadow">
                                <div class="ui-box-title">کاربر مدنظر</div>
                                <div class="ui-box-content">
                                    <div class="row">
                                        <div class=" py-1">
                                            <div class="fs-7 text-dark">شماره تلفن همراه کاربر مدنظر</div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="position-relative w-100">
                                                    <input id="user-phone" data-editable="true"
                                                        onkeypress="return isNumber(event)" type="tel" minlength="7"
                                                        maxlength="11" class="form-control" style="direction: rtl"
                                                        placeholder="شماره تلفن همراه کاربر مدنظر">
                                                    {{-- <button data-input-id="user-phone" class=" toggle-editable-btn btn btn-circle btn-outline-light">
                                                            <i class="ri-ball-pen-fill"></i>
                                                        </button> --}}
                                                </div>
                                                <button id="searchUser" class="btn btn-primary btn-outline-light">
                                                    جستجو
                                                </button>
                                            </div>
                                        </div>
                                        {{-- <div class="fs-6 fw-bold text-muted"></div> --}}
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endif

                    <div
                        class="ui-box bg-white mb-5 boxShadow {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">اطلاعات رابط</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">نام و نام خانوادگی</div>
                                        <div data-remodal-target="personal-info-fullname-modal"
                                            class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-val='test' data-editable="true" id="nameLast" type="text"
                                                class="form-control setName" style="direction: rtl"
                                                placeholder="نام و نام خانوادگی" disabled>
                                            <button data-input-id="nameLast"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light"
                                                data-remodal-target="personal-info-fullname-modal">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">شماره تلفن همراه</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" onkeypress="return isNumber(event) " id="phone"
                                                type="tel" minlength="7" maxlength="11" class="form-control"
                                                style="direction: rtl" placeholder="شماره تلفن همراه">
                                            <button data-input-id="phone"
                                                class=" toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">پست الکترونیک</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true"
                                                onkeypress="return isEmail(event) || isNumber(event)" id="userEmail"
                                                type="email" class="form-control" style="direction: rtl"
                                                placeholder="پست الکترونیک">
                                            <button data-input-id="userEmail"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">تاریخ تولد</div>
                                        <div data-remodal-target="personal-info-birth-modal"
                                            class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-val="test" data-editable="true" id="mainBrithday" type="text"
                                                class="form-control userBirthDay" style="direction: rtl"
                                                placeholder="تاریخ تولد" disabled>
                                            <button data-input-id="mainBrithday"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light"
                                                data-remodal-target="personal-info-birth-modal"><i
                                                    class="ri-ball-pen-fill"></i></button>
                                        </div>
                                        <div id="brithdayVal" class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">کد ملی</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" onkeypress="return isNumber(event)"
                                                minlength="10" maxlength="10" id="nid" type="text"
                                                class="form-control" style="direction: rtl" placeholder="کد ملی">
                                            <button data-input-id="nid"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="ui-box bg-white mb-5 boxShadow {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">تصویر صفحه برگزار کننده</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class=" py-2">
                                        <div style="visibility: hidden">
                                            <input class="b-1" type="file" id="file-ip-1" accept="image/*"
                                                onchange="showPreview(event)">
                                            <input class="b-1" type="file" id="file-ip-2" accept="image/*"
                                                onchange="showPreviewProfile(event)">
                                        </div>
                                        <div class="producer position-relative">
                                            <img id="file-ip-1-preview"
                                                style="border: 2px solid white;boxshadow: 0 3px 6px #00000029;background-color: #e5e5e5"
                                                class="w-100 h-100 objectFitCover" style="opacity: .4" alt="">
                                            <div id="producer" class="position-absolute customTop center uploaderText">
                                                عکس را بارگذاری کنید</div>
                                            <div id="profileImg" class="profileImg">
                                                <img id="file-ip-2-preview"
                                                    style="border: 2px solid white;boxshadow: 0 3px 6px #00000029"
                                                    class="w-100 h-100 objectFitCover" accept="image/*" alt="">
                                                <div id="producer"
                                                    class="position-absolute customTop2 center uploaderImg"><i
                                                        class="icon-visit-open"></i></div>
                                            </div>
                                            <script>
                                                function showPreviewProfile(event) {
                                                    if (event.target.files.length > 0) {
                                                        var src = URL.createObjectURL(event.target.files[0]);
                                                        var preview = document.getElementById("file-ip-2-preview");
                                                        preview.src = src;
                                                        preview.style.display = "flex";
                                                    }
                                                }

                                                function showPreview(event) {
                                                    if (event.target.files.length > 0) {
                                                        var src = URL.createObjectURL(event.target.files[0]);
                                                        var preview = document.getElementById("file-ip-1-preview");
                                                        preview.src = src;
                                                        preview.style.display = "flex";
                                                    }
                                                }
                                                $(document).ready(function() {
                                                    $('#producer').on('click', function() {
                                                        $('#file-ip-1').click();
                                                    });
                                                    $('#profileImg').on('click', function() {
                                                        $('#file-ip-2').click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="ui-box bg-white mb-5 boxShadow {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">نوع برگزار کننده</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-2">
                                        <div class="fs-7 text-dark">نوع شخصیت</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <select id="launcherType" class="select2 selectStyle">
                                                <option value="0" selected>انتخاب کنید</option>
                                                <option value="haghighi">حقیقی</option>
                                                <option value="hoghoghi">حقوقی</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="ui-box bg-white mb-5 boxShadow hidden_all_fields hidden {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">اطلاعات برگزار کننده</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div id="nameOfProducer" class="fs-7 text-dark"></div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" id="companyName" type="text"
                                                class="form-control" style="direction: rtl" placeholder="نام">
                                            <button data-input-id="companyName"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3 hoghoghi_fields">
                                    <div class=" py-2">
                                        <div class="fs-7 text-dark">نوع شرکت</div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <select id="companyType" class="select2 selectStyle">
                                                <option value="0" selected>انتخاب کنید</option>
                                                <option value="art">موسسه فرهنگی و هنری</option>
                                                <option value="limit">مسئولیت محدود</option>
                                                <option value="agency">آژانس</option>
                                                <option value="spec">سهامی خاص</option>
                                                <option value="public">سهامی عام</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3 hoghoghi_fields">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">شماره اقتصادی</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" onkeypress="return isNumber(event)"
                                                id="code" type="text" class="form-control"
                                                style="direction: rtl" placeholder="شماره اقتصادی">
                                            <button data-input-id="code"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">کد پستی</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" onkeypress="return isNumber(event)"
                                                maxlength="10" id="postalCode" type="text" class="form-control"
                                                style="direction: rtl" placeholder="کد پستی">
                                            <button data-input-id="postalCode"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <!-- start of form-element -->
                                    <div class="form-element-row">
                                        <label class="label fs-7">استان</label>

                                        <select onchange="getCities($(this).val())" class="select2" name="state02"
                                            id="state02">
                                            <option value="0">انتخاب کنید</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- end of form-element -->
                                </div>
                                <div id="ha" class="col-lg-6 mb-3">
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
                                <div class="col-lg-12 mb-3">
                                    <div class="py-1 hidden_online_fields">
                                        <div class="fs-7 text-dark">آدرس</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <textarea data-editable="true" id="launcherAddress" type="text" class="form-control" style="direction: rtl"
                                                placeholder="آدرس"></textarea>
                                            <button data-input-id="launcherAddress"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">نقشه</div>
                                        <div id="launchermap" style="width: 100%; height: 250px"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div
                        class="ui-box bg-white mb-5 boxShadow {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">درباره برگزار کننده</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">درباره من</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <textarea data-editable="true" id="aboutme" type="text" class="form-control" style="direction: rtl"
                                                placeholder="درباره من"></textarea>
                                            <button data-input-id="aboutme"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="ui-box bg-white mb-5 boxShadow hidden_all_fields hidden {{ $isEditor && $mode !== 'edit' ? 'searchUserContent searchUserContentHidden' : '' }}">
                        <div class="ui-box-title">اطلاعات تماس</div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">وب سایت</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" id="launcherSite" type="url"
                                                class="form-control" style="direction: rtl"
                                                placeholder=" به عنوان مثال: http://www.site.ir حتما http را وارد کنید">
                                            <button data-input-id="launcherSite"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">پست الکترونیک</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true"
                                                onkeypress="return isEmail(event) || isNumber(event)" id="launcherEmail"
                                                type="text" class="form-control" style="direction: rtl"
                                                placeholder="پست الکترونیک">
                                            <button data-input-id="launcherEmail"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class=" py-1">
                                        <div class="fs-7 text-dark">تلفن</div>
                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                            <input data-editable="true" onkeypress="return isNumber(event)"
                                                minlength="7" maxlength="11" id="launcherPhone" type="text"
                                                class="form-control setEnter" style="direction: rtl" placeholder="تلفن">
                                            <button data-input-id="launcherPhone"
                                                class="toggle-editable-btn btn btn-circle btn-outline-light">
                                                <i class="ri-ball-pen-fill"></i>
                                            </button>
                                        </div>
                                        <div id="addTell" class="d-flex gap15 flexWrap mt-1"></div>
                                        <div class="fontSize14 colorBlack">در صورت وجود بیش از یک تلفن، آن ها را با فاصله
                                            از هم جدا نمایید.همچنین پیش شماره کشور و شهر نیز وارد شود. مانند +982111111111
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spaceBetween mb-2">
                        <a href="" class="px-5 b-0 btnHover backColorWhite colorBlack fontSize18">انصراف</a>
                        @if ($mode == 'edit')
                            <button data-remodal-target="modalAreYouSure" class="btn btn-sm btn-primary px-5">اعمال
                                تغییرات</button>
                        @else
                            <button class="btn btn-sm btn-primary px-5 nextBtn">ثبت اطلاعات</button>
                        @endif
                    </div>

                    @if ($mode == 'edit')
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('launcher-document', ['formId' => $formId]) }}"
                                class="colorBlue fontSize14 ml-33">مشاهده مرحله بعد</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        </div>

        @include('event.layouts.areYouSureChange')
        @include('event.layouts.personalInfoFullName')
        @include('event.layouts.personalInfoBirthDay')

    </main>

    <script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.js">
    </script>
    <link href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.css"
        rel="stylesheet" />
@stop


@section('extraJS')
    @parent

    <script>
        let telsObj = {
            tels: [],
            idx: 1
        };

        let loc = {
            x: undefined,
            y: undefined
        }

        var map = undefined;

        function setValBrithday() {
            var year = $('#Brithday_year').val();
            var month = $('#Brithday_month').val();
            var day = $('#Brithday_day').val();

            if (year.length == 0 || month.length == 0 || month == 0 || day.length == 0) {
                showErr("لطفا تاریخ تولد را وارد کنید.");
                return
            } else {
                $('.userBirthDay').val(year + '/' + month + '/' + day);
                $(".remodal-close").click();
            }
        }

        function setValName() {

            var name = $('#first_name').val();
            var last = $('#last_name').val();

            if (name.length == 0 || last.length == 0) {
                showErr("لطفا نام و نام خانوادگی را وارد نمائید.");
                return
            }

            $('#nameLast').val(name + ' ' + last);
            $('#editBtnName').removeClass('hidden');
            $(".remodal-close").click();
        }

        $(document).ready(function() {

            $("#searchUser").on("click", function() {

                let phone = $("#user-phone").val();
                if (phone.length != 11) {
                    showErr('شماره همراه وارد شده نامعتبر است');
                    return;
                }

                $('#shimmer').removeClass('hidden');
                $('#hiddenHandler').addClass('hidden');

                $.ajax({
                    type: 'post',
                    url: "{{ route('searchUsersForLauncherCandidate') }}",
                    data: {
                        phone: phone
                    },
                    success: function(res) {
                        if (res.status === 'ok') {

                            if (res.data.name != null)
                                $("#nameLast").val(res.data.name);

                            if (res.data.nid != null)
                                $("#nid").val(res.data.nid);

                            if (res.data.birth_day != null)
                                $("#mainBrithday").val(res.data.birth_day);

                            if (res.data.mail != null)
                                $("#userEmail").val(res.data.mail);

                            $("#phone").val(res.data.phone);
                            $(".searchUserContent").removeClass('searchUserContentHidden');

                            removeShimmer();
                        } else
                            showErr(res.msg);
                    }
                });

            });

            function fillWithDefault() {

                $('#shimmer').removeClass('hidden');
                $('#hiddenHandler').addClass('hidden');

                @if (Auth::user()->first_name != null && Auth::user()->last_name != null)
                    $("#nameLast").val('{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}');
                    $("#first_name").val('{{ Auth::user()->first_name }}');
                    $("#last_name").val('{{ Auth::user()->last_name }}');
                @endif

                @if (Auth::user()->nid != null)
                    $("#nid").val('{{ Auth::user()->nid }}');
                @endif


                @if (Auth::user()->birth_day != null)
                    $("#mainBrithday").val('{{ Auth::user()->birth_day }}');
                @endif


                @if (Auth::user()->mail != null)
                    $("#userEmail").val('{{ Auth::user()->mail }}');
                @endif

                $("#phone").val('{{ Auth::user()->phone }}');
                removeShimmer();

            }


            @if (!$isEditor && $mode != 'edit')
                fillWithDefault();
                removeUnNecessaryLocks();
            @endif

            watchEnterInTellInput(telsObj);

            $('#launcherType').on('change', function() {
                var launcherType = $('#launcherType').val();
                if (launcherType === 'haghighi') {
                    // show or hide class for haghighi
                    $(".hoghoghi_fields").addClass('hidden');
                    $(".haghighi_fields").removeClass('hidden');
                    $(".hidden_all_fields").removeClass('hidden');
                    $("#nameOfProducer").text('نام برگزار کننده');
                } else if (launcherType === 'hoghoghi') {
                    // show or hide class for hoghoghi
                    $("#nameOfProducer").text('نام حقوقی');
                    $(".hoghoghi_fields").removeClass('hidden');
                    $(".haghighi_fields").addClass('hidden');
                    $(".hidden_all_fields").removeClass('hidden');
                } else if (launcherType === 'selectType') {
                    // hide All
                    $(".hidden_all_fields").addClass('hidden');
                }

                if (map === undefined)
                    map = createMap('launchermap', loc);

            });

            $('.nextBtn').on('click', function() {

                var nameLast = $('#nameLast').val();
                var name = $('#first_name').val();
                var last = $('#last_name').val();
                var phone = $('#phone').val();
                var setName = $('.setName').val();
                var userEmail = $('#userEmail').val();
                var userBirthDay = $('.userBirthDay').val();
                var mainBrithday = $('#mainBrithday').val();
                var Brithday_day = $('#Brithday_day').val();
                var Brithday_year = $('#Brithday_year').val();
                var nid = $('#nid').val();
                var companyName = $('#companyName').val();
                var launcherType = $('#launcherType').val();
                var companyType = $('#companyType').val();
                var code = $('#code').val();
                var postalCode = $('#postalCode').val();
                var launcherCityID = $('.launcherCityID').val();
                var launcherSite = $('#launcherSite').val();
                var launcherEmail = $('#launcherEmail').val();
                var launcherPhone = $('#launcherPhone').val();
                var launcherType = $('#launcherType').val();
                var launcherAddress = $('#launcherAddress').val();
                var state02 = $('#state02').val()


                let required_list_Select = (launcherType == "hoghoghi") ? ['launcherType', 'state02',
                    'city02', 'companyType'
                ] : ['launcherType', 'state02', 'city02'];

                let required_list = (launcherType == "hoghoghi") ? ['nameLast', 'phone', 'userEmail',
                    'mainBrithday', 'nid', 'companyName', 'postalCode', 'launcherAddress',
                    'code'
                ] : ['nameLast', 'phone', 'userEmail', 'mainBrithday', 'nid', 'companyName',
                    'postalCode', 'launcherAddress',
                ];

                let inputList = checkInputs(required_list);
                let selectList = checkSelect(required_list_Select);

                if (!inputList || !selectList) {
                    showErr('لطفا همه فیلدهای لازم را پر نمایید');
                    return
                }

                $(".showPenEdit").removeClass('hidden')
                if (userEmail == null || userEmail == undefined) {
                    $('#userEmail').css('backgroundColor', 'red')
                }
                if (launcherEmail == null || launcherEmail == undefined) {
                    $('#launcherEmail').css('backgroundColor', 'red')
                }
                if (launcherPhone !== undefined && launcherPhone.length > 0)
                    telsObj.tels.push({
                        id: 222222222,
                        val: launcherPhone
                    });

                if (loc.x === undefined || loc.y === undefined) {
                    showErr("لطفا مکان موردنظر خود را از روی نقضه انتخاب کنید");
                    return;
                }

                let data = {
                    first_name: name,
                    last_name: last,
                    phone: phone,
                    launcher_x: loc.x,
                    launcher_y: loc.y,
                    user_email: userEmail,
                    user_birth_day: userBirthDay,
                    user_NID: nid,
                    company_name: companyName,
                    postal_code: postalCode,
                    launcher_city_id: launcherCityID,
                    launcher_site: launcherSite,
                    launcher_email: launcherEmail,
                    launcher_type: launcherType,
                    launcher_address: launcherAddress,
                };

                let about = $("#aboutme").val();
                if (about !== undefined && about !== null && about.length > 0)
                    data['about'] = about;

                if (launcherType == "hoghoghi") {
                    data.code = code;
                    data.company_type = companyType;
                }

                let formData = new FormData();

                @if ($mode == 'create')
                    const userPhone = $("#user-phone").val();
                    if (userPhone !== undefined)
                        formData.append("user_phone", userPhone);
                @endif


                for (var key in data) {
                    formData.append(key, data[key]);
                }

                telsObj.tels.forEach((elem, index) => {
                    formData.append('launcher_phone[]', elem.val);
                });

                const inputFile = document.getElementById("file-ip-1");
                for (const file of inputFile.files) {
                    formData.append("back_img_file", file);
                }

                const inputFile2 = document.getElementById("file-ip-2");
                for (const file of inputFile2.files) {
                    formData.append("img_file", file);
                }



                $.ajax({
                    type: 'post',
                    url: "{{ $mode == 'create' ? route('launcher.store') : route('launcher.update', ['launcher' => $formId]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status === "ok") {
                            let launcher_id;
                            if ('{{ $mode }}' === 'create') {
                                launcher_id = res.id;
                            } else {
                                launcher_id = '{{ isset($formId) ? $formId : -1 }}';
                            }
                            window.location.href = '{{ route('launcher-document') }}' +
                                "/" +
                                launcher_id;
                        } else {
                            showErr(res.msg);
                        }
                    }
                });
            })
        }) @if ($mode == 'edit')

            $(document).ready(function() {
                $('#shimmer').removeClass('hidden');
                $('#hiddenHandler').addClass('hidden');

                $.ajax({
                    type: 'get',
                    url: '{{ route('launcher.show', ['launcher' => $formId]) }}',
                    success: function(res) {
                        $('input').attr("data-editable", "false");
                        $('textarea').attr("data-editable", "false");
                        $('input[type=file]').attr("data-editable", "true");
                        $('.toggle-editable-btn').removeClass('hidden');

                        loc.x = res.data.launcher_x;
                        loc.y = res.data.launcher_y;
                        $('#first_name').val(res.data.first_name);
                        $('#last_name').val(res.data.last_name);
                        $('.setName').val(res.data.first_name + ' ' + res.data.last_name)
                        $('#phone').val(res.data.phone);
                        $('#aboutme').val(res.data.about);
                        $("#postalCode").val(res.data.postal_code);
                        $("#companyName").val(res.data.company_name);


                        if (res.data.launcher_type == "hoghoghi") {
                            $("#code").val(res.data.code);
                            $("#companyType").val(res.data.company_type).change();
                        }

                        if (res.data.back_img !== null && res.data.back_img !== undefined && res
                            .data
                            .back_img !== 'null' && res.data.back_img.length > 0)
                            $("#file-ip-1-preview").attr('src', res.data.back_img);

                        if (res.data.img !== null && res.data.img !== undefined && res.data
                            .img !==
                            'null' && res.data.img.length > 0)
                            $("#file-ip-2-preview").attr('src', res.data.img);

                        $("#launcherAddress").val(res.data.launcher_address);
                        $(".launcherCityID").val(res.data.launcher_city_id);
                        $("#launcherEmail").val(res.data.launcher_email);

                        if (res.data.user_phone) {
                            $("#user-phone").val(res.data.user_phone);
                        }
                        var showPhone = '';
                        let tels = [];
                        let idx = 1;

                        for (i = 0; i < res.data.launcher_phone.length; i++) {

                            showPhone += '<div id="tel-modal-' + idx +
                                '" class="item-button spaceBetween colorBlack">' + res.data
                                .launcher_phone[i] + '';
                            showPhone +=
                                '<button class="btn btn-outline-light borderRadius50 marginLeft3">';
                            showPhone += '<i data-id="' + idx +
                                '" class="remove-tel-btn ri-close-line"></i>';
                            showPhone += '</button>';
                            showPhone += '</div>';

                            tels.push({
                                id: idx,
                                val: res.data.launcher_phone[i]
                            });
                            idx++;
                        };

                        telsObj.tels = tels;
                        telsObj.idx = idx;

                        $("#addTell").append(showPhone);
                        $("#launcherPhone").attr('data-val', tels.map(elem => {
                            return elem.val;
                        }).join('-'))
                        $("#launcherSite").val(res.data.launcher_site);
                        $("#launcherType").val(res.data.launcher_type).change();
                        $("#nid").val(res.data.user_NID);
                        $("#userEmail").val(res.data.user_email);
                        $("#companyType").val(res.data.company_type);
                        $(".userBirthDay").val(res.data.user_birth_day);
                        $("#state02").val(res.data.launcher_state_id).change();
                        getCities(res.data.launcher_state_id, res.data.launcher_city_id);
                        $("input").each(function() {
                            if ($(this).attr('data-editable') != 'true') {
                                $(this).attr('disabled', 'disabled');
                            }
                        });
                        $("textarea").each(function() {
                            if ($(this).attr('data-editable') != 'true') {
                                $(this).attr('disabled', 'disabled');
                            }
                        });
                        removeShimmer();
                    }
                });

            });
        @endif
    </script>

@stop
