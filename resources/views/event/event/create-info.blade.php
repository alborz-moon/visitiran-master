@extends('layouts.structure')
@section('header')
    @parent
    <script src="{{asset('theme-assets/dropzone/dropzone.js?v=1.2')}}"></script>
    <link rel="stylesheet" href="{{asset("theme-assets/dropzone/dropzone.css")}}">
    <script src="{{asset('theme-assets/js/Utilities.js')}}"></script>
    <script>
        var UploadURL = '{{ route('uploadImg') }}';
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{asset('admin-panel/js/ckeditor.js?v=2.2')}}"></script>

@stop

@section('content')
    <main class="page-content TopParentBannerMoveOnTop">
        <div class="dark hidden"></div>
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
                            <span class="colorBlack  fontSize15 bold d-none d-md-block fontSize16 bold">ایجاد رویداد</span>
                            <ul class="checkout-steps mt-4 mb-3 w-100">
                                <li class="checkout-step-active">
                                    <a href="{{ route('update-event', ['event' => $id]) }}"><span class="checkout-step-title" data-title="اطلاعات کلی"></span></a>
                                </li>
                                <li class="checkout-step-active">
                                    <a href="{{ route('addSessionsInfo', ['event' => $id]) }}"><span class="checkout-step-title" data-title="زمان برگزاری"></span></a>
                                </li>
                                <li class="checkout-step-active">
                                    <a href="{{ route('addPhase2Info', ['event' => $id]) }}"><span class="checkout-step-title" data-title="ثبت نام و تماس"></span></a>
                                </li>
                                <li class="checkout-step-active">
                                    <a><span class="checkout-step-title" data-title="اطلاعات تکمیلی"></span></a>
                                </li>
                            </ul>
                            <a href="{{ route('addPhase2Info', ['event' => $id]) }}" class="px-3 b-0 btnHover backColorWhite colorBlack fontSize18">بازگشت</a>
                        </div>

                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title"> عکس اصلی رویداد</div>
                            <div class="ui-box-content">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        @include('event.launcher.dropZone', [
                                            'col' => 'col-12', 
                                            'label' => 'عکس اصلی رویداد',
                                            'key' => 'main_img',
                                            'camelKey' => 'mainImg',
                                            'maxFiles' => 1,
                                            'route' => route('event.set_main_img',['event' => $id]),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ui-box bg-white mb-5 boxShadow">
                            <div class="ui-box-title">گالری عکس</div>
                                <div class="col-lg-12 mb-3 zIndex0">
                                        
                                    <div id="certifications" class="boxGallery gap10">
                                        <div class="square">
                                        </div>
                                    </div>

                                    <div iclass="uploadBody">
                                        <div class="uploadBorder">
                                            <div class="uploadBodyBox" style="padding-bottom: 50px">
                                                <form id="gallery-form" action="{{route('event.galleries.store', ['event' => $id])}}" class="dropzone uploadBox">
                                                    {{csrf_field()}}
                                                </form>
                                                {{-- <div id="dropZoneErr" style="margin-top: 25px; font-size: 1.2em; color: red;" class="hidden">شما اجازه بارگذاری چنین فایلی را ندارید.</div>
                                                <div class="uploadّFileAllowed">حداکثر فایل مجاز: 100 مگابایت</div> --}}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui-box bg-white mb-5 boxShadow">
                                <div class="ui-box-title">توضیحات</div>
                                <div class="ui-box-content">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="py-2">
                                                
                                                @if(isset($desc) && $desc != null)
                                                    <div id="showDescContainer" class="d-flex align-items-center justify-content-between position-relative">
                                                        <div id="showDesc" class="form-control" style="direction: rtl; background-color: #e9ecef;">{!! $desc !!}</div>
                                                        @include('event.layouts.lock', ['id' => 'showDesc'])
                                                    </div>
                                                @endif
                                                
                                                <div id="ck" class="{{ isset($desc) && $desc != null ? 'hidden' : '' }}">
                                                    <div id="toolbar-container"></div>
                                                    @if(isset($desc) && $desc != null)
                                                        <div id="description">{!! $desc !!}</div>
                                                    @else
                                                        <div id="description">توضیحات</div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="spaceBetween mb-2">
                                <a href="{{ route('show-events') }}" class="px-5 b-0 btnHover backColorWhite colorBlack fontSize18">انصراف</a>
                                @if($mode == 'edit')
                                    <button data-remodal-target="modalAreYouSure" class="btn btn-sm btn-primary px-5">ارسال برای بازبینی</button>
                                @else
                                    <button class="btn btn-sm btn-primary px-5 nextBtn">ارسال برای بازبینی</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="remodal remodal-xl" data-remodal-id="mainImgShow"
            data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div id="mainImgModal">
                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>

        <div class="remodal remodal-xl" data-remodal-id="mainGallery"
            data-remodal-options="hashTracking: false">
            <div class="remodal-header">
                <div class="remodal-title">مشاهده عکس</div>
                <button data-remodal-action="close" class="remodal-close"></button>
            </div>
            <div class="remodal-content">
                <div class="form-element-row mb-3">
                    <div>
                        <img id="mainGalleryModal" class="w-100 h-100 objectFitCover" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="remodal-footer">
                <button data-remodal-action="close" class="btn btn-sm btn-primary px-3">بستن</button>
            </div>
        </div>

        @include('event.layouts.areYouSureChange')

    </main>
@stop

@section('extraJS')
    @parent
    
    <script src="{{asset('admin-panel/js/initCKs.js?v=2.3')}}"></script>
    
    <script>
        
        let uploadedFiles = [];
        let total = 0;
        @if(isset($desc) && $desc != null)
            let changeDesc = false;
        @else
            let changeDesc = true;
        @endif

        Dropzone.options.galleryForm = {
            paramName: "img_file", // The name that will be used to transfer the file
            maxFilesize: 5, // MB
            timeout: 180000,
            parallelUploads: 1,
            chunking: false,
            forceChunking: false,
            uploadMultiple: false,
            maxFiles: 8,
            accept: function(file, done) {
                done();
            },
            init: function () {
                this.on("success", function (file, res, e) {
                    uploadedFiles.push({
                        name: file.name,
                        id: res.id
                    });
                    $(".dz-message").removeClass('block');
                    showSuccess('فایل شما با موفقیت آپلود شد');
                });
            }
        }

        $(document).ready(function () {
            
            initCK('{{ csrf_token() }}');
            
            $("#saveBtn").on('click', function() {
                $("#desc").val($("#description").html());
                $("#myForm").submit();
            });

            $(".toggle-editable-btn").on("click", function () {
                changeDesc = true;
                $("#showDescContainer").remove();
                $("#ck").removeClass('hidden');
            });

        });
        
        function sendimg(img){
            $("#mainGalleryModal").attr('src', img);
        }

        $('#shimmer').removeClass('hidden');
        $('#hiddenHandler').addClass('hidden');

        $.ajax({
            type: 'get',
            url: '{{route('event.galleries.index',['event' => $id])}}',
            success: function(res) {
                var gallery = "";
                if(res.status === "ok") {
                    $('textarea').attr("data-editable", "false");
                    if(res.data.length != 0) {
                        total = res.data.length;
                        for(i = 0; i < res.data.length; i ++ ) {
                            gallery += '<div onclick="sendimg(\'' + res.data[i].img + '\')" data-remodal-target="mainGallery" id="gallery_' + res.data[i].id + '" class="square cursorPointer">';
                            gallery += '<img class="w-100 h-100 objectFitCover" src="' + res.data[i].img + '" alt="">';
                            gallery += '<i data-id=' + res.data[i].id + ' class="icon-visit-delete position-absolute colorRed fontSize21 topLeft10"></i>';
                            gallery += '</div>';
                        }
                        $("#certifications").empty().append(gallery);
                    }
                    else
                        $("#certifications").remove();
                    
                    removeShimmer();
                }
            }
        });

        $.ajax({
            type: 'get',
            url: '{{route('event.get_main_img' ,['event' => $id])}}',
            success: function(res) {
                var mainProfileEvent = "";
                if(res.status === "ok") {
                    if (res.img.length != 0){
                        let html = '<div data-remodal-target="mainImgShow" class="square cursorPointer position-relative square">';
                        html += '<img class="w-100 h-100 objectFitCover" src="' + res.img + '">';
                        html += '</div>';
                        $("#drop_zone_container_main_img").addClass('hidden');
                        $("#gallery_container_main_img").append(html);
                        $("#edit_btn_main_img").removeClass('hidden');
                        $('#mainImgModal').empty().append('<img class="w-100 h-100 objectFitCover" src="' + res.img + '" alt="">')
                    }else {
                        $("#gallery_container_main_img").remove();
                    }
                }
            }
        });
        
        $(document).on('click', ".icon-visit-uploaded-delete", function() {
            
            let filename = $(this).siblings('.dz-filename').text();
            let tmp = uploadedFiles.find(elem => elem.name === filename);
            if(tmp === undefined)
                return;

            let parentElem = $(this).parent().parent();

            $.ajax({
                type: 'delete',
                url: '{{ route('event.galleries.destroy') }}' + "/" + tmp.id,
                success: function(res) {
                    if(res.status === 'ok') {
                        uploadedFiles = uploadedFiles.filter((elem, index) => {
                            return elem.id !== tmp.id;
                        });
                        parentElem.remove();
                        if(uploadedFiles.length === 0)
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
                url: '{{ route('event.galleries.destroy') }}' + "/" + id,
                success: function(res) {
                    if(res.status === 'ok') {
                        $("#gallery_" + id).remove();
                        showSuccess('فایل موردنظر با موفقیت حذف گردید.');

                        console.log(uploadedFiles.length);
                        total--;

                        if(total === 0)
                            $("#certifications").remove();
                    }
                }
            });
        });

        $(".nextBtn").on('click', function () {
            
            if(changeDesc) {
                var description = $('#description').html();

                if (description.length == 0) {
                    showErr("فیلد توضیحات را پر کنید");
                    return;
                }

                $.ajax({
                    type: 'post',
                    url: '{{route('event.store_desc',['event' => $id])}}',
                    data: {
                        'description': description,
                    },
                    success: function(res) {
                        if(res.status === "ok")
                            sendForReview();
                    }
                });
            }
            else
                sendForReview();
        });
        
        function sendForReview() {
            
            $.ajax({
                type: 'post',
                url: '{{route('event.sendForReview',['event' => $id])}}',
                success: function(res) {
                    if(res.status === "ok")
                        window.location.href = '{{ $isEditor ? route('event.index') :  route('show-events')}}';
                    else
                        showErr(res.data)
                }
            });
        
        }

    </script>
@stop