 <div id="shimmer" class="hidden"> 
    @for($i = 0; $i < 1; $i++)
        <a href="#" class="cursorPointer">
            <div class="ui-box bg-white mb-5 boxShadow SimmerParent">
                <div class="ui-box-title shimmerBG title-line m-3" style="width: 150px"></div>
                <div class="ui-box-content">
                    <div class="row">
                        <div class=" py-1">
                            <div class="fs-7 text-dark shimmerBG title-line m-3" style="width: 300px"></div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="position-relative w-100">
                                    <div class="shimmerBG title-line p-5 m-3 w-100">
                                        {{-- <div class="shimmerBG title-line m-3" style="width: 50px"></div> --}}
                                    </div>
                                    <div class="shimmerBG title-line m-3" style="width: 200px;float: left"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endfor
</div>