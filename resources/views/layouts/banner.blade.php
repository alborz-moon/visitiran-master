<div class="w-100 mb-5 backgroundWhite banner">
    <div class="container">
        <div class="row mb-3 customPaddingTopBottom10">
            <div class="col-md-6 mb-lg-0 mb-3">
                <!-- start of banner -->
                <div class="banner-img">
                    <a href="#" class="position-relative">
                        <img id="banner1">
                        <div class="arrowLeftIcon positionAbsolute customArrowLeftIcon backgroundGray"><img src="{{ asset('theme-assets/images/svg/ionic-ios-arrow-round-back.svg') }}"></div>
                    </a>
                </div>
                <!-- end of banner -->
            </div>
            <div class="col-md-6 mb-lg-0 mb-3">
                <!-- start of banner -->
                <div class="banner-img">
                    <a href="#" class="position-relative">
                        <img id="banner2">
                        <div class="arrowLeftIcon positionAbsolute customArrowRightIcon backgroundGray"><img src="{{ asset('theme-assets/images/svg/ionic-ios-arrow-round-back.svg') }}"></div>
                    </a>
                </div>
                <!-- end of banner -->
            </div>
        </div>
    </div>
</div>
    <script>
        $.ajax({
            type: 'get',
            url: '{{ route('api.banner', ['section', 'home']) }}',
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {
                if(res.status === "ok") {
                    if(res.data.length === 0) {
                        $('.banner').addClass('hidden');
                    }
                    if(res.data.length > 0)
                        $("#banner1").attr('href', res.data[0].href).attr('src', res.data[0].img);

                    if(res.data.length > 1)
                        $("#banner2").attr('href', res.data[1].href).attr('src', res.data[1].img);
                }
            }
        });
    </script>