@extends('layouts.structure')

@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('theme-assets/bootstrap-datepicker.css?v=1') }}">
    <script src="{{ asset('theme-assets//bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('theme-assets/dropzone/dropzone.js?v=1.2') }}"></script>
    <link rel="stylesheet" href="{{ asset('theme-assets/dropzone/dropzone.css') }}">

@stop

@section('content')
    <main class="page-content TopParentBannerMoveOnTop">

        <div class="dark hidden"></div>

        <div class="container">
            <div class="row mb-5">
                <?php $isEditor = Auth::user()->isEditor(); ?>
                @if (!$isEditor)
                    @include('event.launcher.launcher-menu')
                @endif
                <div class="{{ $isEditor ? 'col-xl-12 col-lg-12 col-md-12' : 'col-xl-9 col-lg-8 col-md-7' }}">

                    @include('event.layouts.shimmer')

                    <div id="hiddenHandler">
                        <div class="alert alert-warning alert-dismissible fade show mb-5 d-flex align-items-center spaceBetween"
                            role="alert">
                            <div>
                                در حال حاضر حساب کاربری شما غیر فعال است. پس از بررسی مدارک و تایید از سوی ادمین حساب شما
                                فعال خواهد شد.
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mx-3">تیکت ها</a>
                        </div>
                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">مدارک<span class="fontNormal fontSize12 mx-2">حداکثر 2 مگابایت و در
                                    فرمت های jpg, jpeg , png</span></div>
                            <div class="ui-box-content">
                                <div class="row">

                                    @if ($type == 'hoghoghi')
                                        @include('event.launcher.dropZone', [
                                            'label' => 'بارگذاری فایل روزنامه تاسیس',
                                            'key' => 'company_newspaper_file',
                                            'camelKey' => 'companyNewspaperFile',
                                            'maxFiles' => 1,
                                            'route' => route('launcher.update', ['launcher' => $formId]),
                                        ])

                                        @include('event.launcher.dropZone', [
                                            'label' => 'بارگذاری فایل آخرین تغییرات',
                                            'key' => 'company_last_changes_file',
                                            'camelKey' => 'companyLastChangesFile',
                                            'maxFiles' => 1,
                                            'route' => route('launcher.update', ['launcher' => $formId]),
                                        ])
                                    @endif

                                    @include('event.launcher.dropZone', [
                                        'label' => 'بارگذاری فایل کارت ملی رابط',
                                        'key' => 'user_nid_card_file',
                                        'camelKey' => 'userNidCardFile',
                                        'maxFiles' => 1,
                                        'route' => route('launcher.update', ['launcher' => $formId]),
                                    ])

                                    <hr class="mb-3">

                                    <div class="col-lg-12 mb-3 zIndex0">
                                        <div class="mb-3 uploadTitleText">بارگذاری فایل مجوز ها</div>
                                        <div id="certifications" class="boxGallery">
                                        </div>
                                        <div class="uploadBody">
                                            <div class="uploadBorder">
                                                <div class="uploadBodyBox">
                                                    <form id="permision_form"
                                                        action="{{ route('launcher.launcher_certifications.store', ['launcher' => $formId]) }}"
                                                        class="dropzone uploadBox">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    {{-- onclick="window.location.href = '{{ route('finance') }}';" --}}
                                </div>
                            </div>
                        </div>
                        <div class="spaceBetween mb-2">
                            <a href="{{ route('launcher-edit', ['launcher' => $formId]) }}"
                                class="px-5 b-0 btnHover backColorWhite colorBlack fontSize18">بازگشت</a>
                            @if ($mode == 'edit')
                                <button data-remodal-target="modalAreYouSure" class="btn btn-sm btn-primary px-5">ارسال برای
                                    بازبینی</button>
                            @else
                                <button class="btn btn-sm btn-primary px-5 nextBtn">ارسال برای بازبینی</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start of personal-info-fullname-modal -->
        <div class="remodal remodal-xl" data-remodal-id="companyLastChangesShow" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div id="companyLastChangesImg">

                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>
        <!-- end of personal-info-fullname-modal -->

        <!-- start of personal-info-fullname-modal -->
        <div class="remodal remodal-xl" data-remodal-id="companyNewspaperShow" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div id="companyNewspaperImg">

                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>
        <!-- end of personal-info-fullname-modal -->
        <!-- start of personal-info-fullname-modal -->
        <div class="remodal remodal-xl" data-remodal-id="userNIDCardShow" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div id="userNIDCardImg">

                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>
        <!-- end of personal-info-fullname-modal -->
        <!-- start of personal-info-fullname-modal -->
        <div class="remodal remodal-xl" data-remodal-id="certificationsShow" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div id="userNIDCardImg">
                        <img id="certificationsGallery" class="w-100 h-100 objectFitCover" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>

        @if ($mode == 'edit')
            @include('event.layouts.areYouSureChange')
        @endif

        <div class="remodal remodal-xl" data-remodal-id="mainGalleryModal" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div>
                        <img id="mainGallery" class="w-100 h-100 objectFitCover" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>
        <!-- start of personal-info-fullname-modal -->
        <div class="remodal remodal-xl" data-remodal-id="dropZoneModal" data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">ویرایش عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div id="dropZoneModalDropZoneContainer" class="form-element-row mb-3">

                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>
        <!-- end of personal-info-fullname-modal -->
    </main>


@stop

@section('extraJS')
    @parent
    <script>
        let total = 0;

        $(document).ready(function() {
            $('#shimmer').removeClass('hidden');
            $('#hiddenHandler').addClass('hidden');
            $.ajax({
                type: 'get',
                url: '{{ route('launcher.files', ['launcher' => $formId]) }}',
                headers: {
                    'accept': 'application/json'
                },
                success: function(res) {
                    if (res.status === "ok") {
                        var html = "";
                        var companyNewspaper = "";
                        var userNIDCard = "";
                        var certifications = "";
                        var certificationsGallery = "";

                        total = res.data.certifications.length;

                        if (res.data.company_last_changes.length !== 0) {
                            html +=
                                '<div data-remodal-target="companyLastChangesShow" class="square cursorPointer position-relative">';
                            html += '<img class="w-100 h-100 objectFitCover" src="' + res.data
                                .company_last_changes + '">';
                            html += '</div>';
                            $("#drop_zone_container_company_last_changes_file").addClass('hidden');
                            $("#gallery_container_company_last_changes_file").append(html);
                            $("#edit_btn_company_last_changes_file").removeClass('hidden');
                            $('#companyLastChangesImg').empty().append(
                                '<img class="w-100 h-100 objectFitCover" src="' + res.data
                                .company_last_changes + '" alt="">');
                        } else {
                            $('#companyLastChanges').addClass('hidden');
                            $("#gallery_container_company_last_changes_file").remove();
                        }
                        if (res.data.company_newspaper.length !== 0) {
                            companyNewspaper +=
                                '<div data-remodal-target="companyNewspaperShow" class="square cursorPointer position-relative">';
                            companyNewspaper += '<img class="w-100 h-100 objectFitCover" src="' + res
                                .data.company_newspaper + '">';
                            companyNewspaper += '</div>';
                            $("#drop_zone_container_company_newspaper_file").addClass('hidden');
                            $("#gallery_container_company_newspaper_file").append(companyNewspaper);
                            $("#edit_btn_company_newspaper_file").removeClass('hidden');
                            $('#companyNewspaperImg').empty().append(
                                '<img class="w-100 h-100 objectFitCover" src="' + res.data
                                .company_newspaper + '" alt="">');
                        } else {
                            $('#companyNewspaper').addClass('hidden');
                            $("#gallery_container_company_newspaper_file").remove();
                        }
                        if (res.data.user_NID_card.length !== 0) {
                            userNIDCard +=
                                '<div data-remodal-target="userNIDCardShow" class="square cursorPointer position-relative">';
                            userNIDCard += '<img class="w-100 h-100 objectFitCover" src="' + res.data
                                .user_NID_card + '" alt="">';
                            userNIDCard += '</div>';
                            $("#drop_zone_container_user_nid_card_file").addClass('hidden');
                            $("#gallery_container_user_nid_card_file").append(userNIDCard);
                            $("#edit_btn_user_nid_card_file").removeClass('hidden');
                            $('#userNIDCardImg').empty().append(
                                '<img class="w-100 h-100 objectFitCover" src="' + res.data
                                .user_NID_card + '" alt="">');
                        } else {
                            $('#userNIDCard').addClass('hidden');
                            $("#gallery_container_user_nid_card_file").remove();
                        }
                        if (res.data.certifications.length !== 0) {

                            for (i = 0; i < res.data.certifications.length; i++) {
                                certifications += '<div onclick="sendimg(\'' + res.data.certifications[
                                        i].file +
                                    '\')" data-remodal-target="mainGalleryModal" id="gallery_' + res
                                    .data.certifications[i].id + '" class="square cursorPointer">';
                                certifications += '<img class="w-100 h-100 ObjectFitCover" src="' + res
                                    .data.certifications[i].file + '" alt="">';
                                certifications += '<i data-id=' + res.data.certifications[i].id +
                                    ' class="icon-visit-delete position-absolute colorRed fontSize21 topLeft10"></i>';
                                certifications += '</div>';
                            }
                            $("#certifications").empty().append(certifications);

                        } else {
                            $('#certifications').addClass('hidden');
                        }
                        $('#shimmer').addClass('hidden');
                        $('#hiddenHandler').removeClass('hidden');
                    }
                }
            });
        });

        function sendimg(img) {
            $("#mainGallery").attr('src', img);
        }
        let uploadedFiles = [];

        Dropzone.options.permisionForm = {
            paramName: "img_file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            timeout: 180000,
            parallelUploads: 1,
            chunking: false,
            forceChunking: false,
            uploadMultiple: false,
            maxFiles: 5,
            accept: function(file, done) {
                done();
            },
            init: function() {
                this.on("success", function(file, res, e) {

                    uploadedFiles.push({
                        name: file.name,
                        id: res.id
                    });

                    $(".dz-message").removeClass('block');
                    showSuccess('فایل شما با موفقیت آپلود شد');

                });
            }
        };

        $(document).on('click', ".icon-visit-uploaded-delete", function() {

            let filename = $(this).siblings('.dz-filename').text();
            let tmp = uploadedFiles.find(elem => elem.name === filename);
            if (tmp === undefined)
                return;

            let parentElem = $(this).parent().parent();

            $.ajax({
                type: 'delete',
                url: '{{ route('launcher.cert.destroy', ['launcher' => $formId]) }}',
                data: {
                    mode: 'cert',
                    id: tmp.id
                },
                success: function(res) {
                    if (res.status === 'ok') {
                        uploadedFiles = uploadedFiles.filter((elem, index) => {
                            return elem.id !== tmp.id;
                        });
                        parentElem.remove();
                        if (uploadedFiles.length === 0)
                            $(".dz-message").addClass('block');

                        showSuccess('فایل موردنظر با موفقیت حذف گردید.');
                    }
                }
            });
        });


        $(document).on('click', ".icon-visit-delete", function() {

            let id = $(this).attr('data-id');

            $.ajax({
                type: 'delete',
                url: '{{ route('launcher.cert.destroy', ['launcher' => $formId]) }}',
                data: {
                    mode: 'cert',
                    id: id
                },
                success: function(res) {
                    if (res.status === 'ok') {
                        $("#gallery_" + id).remove();
                        showSuccess('فایل موردنظر با موفقیت حذف گردید.');

                        console.log(uploadedFiles.length);
                        total--;

                        if (total === 0)
                            $("#certifications").remove();
                    }
                }
            });
        });

        $(document).on('click', '.nextBtn', function() {

            $.ajax({
                type: 'post',
                url: '{{ route('launcher.send_for_review', ['launcher' => $formId]) }}',
                success: function(res) {
                    if (res.status === "ok")
                        window.location.href =
                        '{{ $isEditor ? route('launcher.index') : route('profile.my-tickets') }}';
                    else
                        showErr(res.data)
                }
            });

        });


        $("#submit").on("click", function() {
            showSuccess("ارسال شد.");
        });
    </script>
@stop
