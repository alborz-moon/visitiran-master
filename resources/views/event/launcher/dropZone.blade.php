<div id="drop_zone_parent_{{ $key }}" class="{{isset($col) && $col == 'col-12' ? 'col-lg-12' : 'col-lg-6'}} mb-3 zIndex0">
    <div class="d-flex spaceBetween">
        <div class="mb-3 uploadTitleText">{{$label}}</div>
        {{-- data-remodal-target="dropZoneModal" --}}
        {{-- onclick="cloneElemToModal('{{ $key }}')" --}}
        <button onclick="show_modal('{{ $key }}')" id="edit_btn_{{ $key }}" class="hidden colorBlue b-0 backgroundColorTransparent">ویرایش</button>
    </div>
    <div id="gallery_container_{{$key}}" class="boxGallery">
    </div>

    <div id="drop_zone_container_{{ $key }}">
        <div class="uploadBody">
            <div class="uploadBorder">
                <div class="uploadBodyBox">
                    <form action="{{ $route }}" class="dropzone uploadBox" id="{{$key}}">
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function closeMyModal(key) {
        $("#drop_zone_parent_" + key).addClass('zIndex0');
        $("#drop_zone_container_" + key).removeClass('myModal').addClass('hidden');
        $("#close_my_modal_" + key).remove();
        $(".dark").addClass('hidden');
    }

    function show_modal(key) {
        $("#drop_zone_parent_" + key).removeClass('zIndex0');
        $("#drop_zone_container_" + key).append('<button class="btn btn-primary mt-2 floatLeft" id="close_my_modal_' + key + '" onclick="closeMyModal(\'' + key + '\')">انصراف</button>').addClass('myModal b-0').removeClass('hidden');
        $(".dark").removeClass('hidden');
    }

    Dropzone.options.{{$camelKey}} = {
        paramName: '{{$key}}', // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        timeout: 180000,
        parallelUploads: 1,
        chunking: false,
        forceChunking: false,
        uploadMultiple: false,
        maxFiles: '{{$maxFiles}}',
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        accept: function(file, done) {
            done();
        },
        init: function () {
            this.hiddenFileInput.removeAttribute('multiple');
            this.on("success", function (file) {
                uploadedFiles.push({
                    name: file.name,
                    id: '{{$key}}'
                });
                $(".dz-message").removeClass('block');
                showSuccess('فایل شما با موفقیت آپلود شد');
                $("#gallery_container_{{$key}}").remove();
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            });
        }
    }
</script>