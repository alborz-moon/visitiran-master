<div class="mb-5">
    <div class="d-flex spaceBetween align-items-center">
        <div class="fontSize18 bold mb-3">برگزار کننده</div>
        @if (!isset($showLauncher) || !$showLauncher)
            <div>
                <div class="d-flex justify-content-end mt-1 mb-2">
                    <button class="whiteSpaceNoWrap buttonBasketEvent btnEventHover d-flex alignItemsCenter">
                        <a href="{{ $launcherHref }}">
                            <span class="colorWhiteGray fontSize13 paddingRight5 px-2">مشاهده</span>
                            <i class="icon-visit-eye colorWhiteGray verticalAlign-2 px-2"></i>
                        </a>
                    </button>

                    @if (isset($launcher_is_following))
                        <button data-select="{{ $launcher_is_following ? 'on' : 'off' }}"
                            class=" d-flex alignItemsCenter whiteSpaceNoWrap buttonBasketEvent followToggle {{ $launcher_is_following ? 'backgroundYellow' : '' }}">
                            <span class="colorWhiteGray fontSize13 px-2 d-flex folllowText">
                                {{ $launcher_is_following ? 'دنبال شده' : 'دنبال کردن' }}
                            </span>
                            <i class="icon-visit-person colorWhiteGray d-flex px-2"></i>
                        </button>
                    @endif

                </div>
            </div>
        @endif
    </div>
    <div class="d-flex align-items-center mb-4">
        <div class="userCircleSize backgroundYellow mx-3 position-relative">
            <img id="imgLauncher"
                class="w-100 h-100 objectFitCover ovrtFlowHidden position-absolute borderRadius50 m-0">
        </div>
        <div class="d-flex flexDirectionColumn">
            <div class="d-flex mt-2">
                <div id="company_name" class="fontSize15 bold colorBlack overFlowHidden"></div>
                <div class=" align-items-center px-2 px-2 fontSize15 colorYellow">
                    <i class=" fontSize15 icon-visit-star me-1 fontSize14 verticalAlign-2"></i><span
                        id="rate"></span>
                    <span class="textColor">(از <span id="rate_count"></span> رای)</span>
                </div>
            </div>
        </div>
    </div>
    <div id="about" class="textStyle">

    </div>
    <div class="d-flex align-items-center">
        <i class="icon-visit-location colorYellow fontSize35 marginTop10"></i>
        <span id="launcherAddress" class="fontSize13 fontNormal colorBlack mx-3 overFlowHidden"></span>
    </div>
    <div class="d-flex align-items-center">
        <i class="icon-visit-phone colorYellow fontSize35 marginTop10"></i>
        <div id="launcher_phone"></div>

    </div>
    <div class="d-flex align-items-center spaceBetween">
        <i class="icon-visit-mail colorYellow fontSize35 marginTop10"></i>
        <a id="launcherEmail" class="fontSize13 fontNormal colorBlack mx-3 overFlowHidden d-flex justifyContentEnd"></a>
    </div>
    <div class="d-flex align-items-center spaceBetween">
        <i class="icon-visit-website colorYellow fontSize35 marginTop10"></i>
        <a id="launcherSite" class="fontSize13 fontNormal colorBlack mx-3 overFlowHidden d-flex justifyContentEnd"></a>
    </div>
</div>
<!-- end of product-gallery -->
<script>
    $('#followTogglelauncher').on('click', function() {
        if ($(this).attr('data-select') === 'off')
            $('#followTogglelauncher').css('backgroundColor', '#c59358').attr('data-select', 'on');
        else
            $('#followTogglelauncher').css('backgroundColor', 'transparent').attr('data-select', 'off');
    });
    $.ajax({
        type: 'get',
        url: '{{ route('api.launcher.show-user', ['launcher' => $launcherId]) }}',
        headers: {
            'accept': 'application/json'
        },
        success: function(res) {
            var html = "";
            if (res.status === "ok") {
                if (res.data.about != null) {
                    $('#about').empty().append(res.data.about);
                }
                if (res.data.company_name != null) {
                    $('#company_name').empty().append(res.data.company_name);
                }
                if (res.data.img != null) {
                    $('#imgLauncher').attr('src', res.data.img);
                }
                if (res.data.launcher_address != null) {
                    $('#launcherAddress').empty().append(res.data.launcher_address);
                }
                if (res.data.launcher_email != null) {
                    $('#launcherEmail').empty().attr('href', 'mailto:' + res.data.launcher_email).text(res
                        .data.launcher_email);
                }
                if (res.data.launcher_site != null) {
                    $('#launcherSite').empty().attr('href', res.data.launcher_site).text(res.data
                        .launcher_site);
                }
                if (res.data.rate != null) {
                    $('#rate').empty().append(res.data.rate);
                }
                if (res.data.rate_count != null) {
                    $('#rate_count').empty().append(res.data.rate_count);
                }
                if (res.data.launcher_phone != null) {
                    for (i = 0; i < res.data.launcher_phone.length; i++) {
                        html += '<a href="tell:' + res.data.launcher_phone[i] +
                            '" class="fontSize13 fontNormal colorBlack mx-3">' + res.data.launcher_phone[
                                i] + '</a>'
                    }
                    $('#launcher_phone').empty().append(html);
                }
            }
        }
    });
</script>
