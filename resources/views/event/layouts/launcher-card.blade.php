    <!-- start of launcher-card -->
    <div class="product-card customBorderBoxShadow minWidth200">
        <div class="product-thumbnail mx-n15">
            <a>
                <img class="objectFitCover" id="{{ $key }}Img">
            </a>
        </div>
        <div class="product-card-body">
            <h2 class="product-title">
                <a id="{{ $key }}Header" class="textColor fontSize14 bold"></a>
            </h2>
            <div class="product-variant">
                <span id="sampleTag_17" class="colorWhite customBoxLabel fontSize11">
                    <div style="display: flex!important" class="align-items-center px-2 fontSize14 fontWight400">
                        <i class="fontSize14 fontWight400 icon-visit-person me-1 fontSize14 verticalAlign-2"></i>
                        <span id="{{ $key }}Followers"></span>
                    </div>
                </span>
            </div>
            <div id="sampleMultiColor_17" class="colorCircle hidden">
            </div>
            <div class="spaceBetween mt-3 mb-3">
                <span></span>
                <span id="{{ $key }}Rate"></span>
            </div>
        </div>
        <div class="product-card-footer mb-2">
            <div id="mostSeenEventLauncherParent" class="textColor">
                <span class="bold">رویدادهای فعال:</span>
                <span id="{{ $key }}ActiveEvents"></span>
            </div>
            <div id="mostSeenEventLauncherParent2" class="textColor">
                <span class="bold">کل رویدادها:</span>
                <span id="{{ $key }}AllEvents"></span>
            </div>
        </div>
    </div>
    <!-- end of launcher-card -->
