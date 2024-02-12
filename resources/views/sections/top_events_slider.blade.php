<!-- start of box -->
<div id="{{ $id }}" class="w-100 my-slider mb-5 hidden">
    <div class="container">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20 d-flex"> 
                <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">{{ $title }} 
                <span class="marginTopNegative10">
                    @if (isset($fill_input))
                        <div style="width: 250px;">
                            <select id="allTagsFilter2" onchange="changeTag($(this).val())" class="select2 seachbar-select w-100">
                                <option selected value="0">موضوع رویداد</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->label }}">{{ $tag->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </span>
            </span>
            
            <span class="alignItemsCenter colorBlue">
                @if(isset($href))
                    <a class="hoverBold" target="_blank" href="{{ isset($href) ? $href : '' }}">
                        مشاهده همه
                    </a>
                @else
                    <a class="seeAll hoverBold cursorPointer">
                        مشاهده همه
                    </a>
                @endif
                </span>
        </div>
        <div class="ui-box-content">
            <!-- Slider main container -->
            <div class="swiper {{ $key }}-product-swiper-slider">
                <!-- Additional required wrapper -->
                <div id="{{ $key }}sSlider" class="swiper-wrapper">
                    <!-- Slides -->
                    <div id="{{ $key }}sSample" class="hidden customEventWidthBox">
                        <div>
                            <!-- start of product-card -->
                            <div class="product-card customEventBorderBox">
                                <div class="product-thumbnail mx-n15">
                                    <a>
                                        <img class="objectFitCover" style="width: 300px;height: 180px;max-width: 300px !important;" id="{{ $key }}Img">
                                    </a>
                                </div>
                                <div class="product-card-body">
                                    <h2 class="product-title">
                                        <a id="{{ $key }}Header" class="textColor fontSize14 bold"></a>
                                    </h2>
                                    <h2 id="{{ $key }}StartContainer" class="product-title hidden">
                                        <span class="fontSize14">شروع</span>
                                        <a id="{{ $key }}Header2" class="textColor fontSize14"></a>
                                    </h2>
                                    <div class="product-variant">
                                        <span id="{{ $key }}Tag" class="colorWhite customBoxLabel fontSize11"></span>
                                    </div>
                                    <div id="{{ $key }}MultiColor" class="colorCircle hidden"></div>
                                    <div class="product-price fa-num">
                                        <div id="{{ $key }}OffSection" class="hidden d-flex align-items-center">
                                            <span class="fontSize15 pl-10 position-relative">
                                                <img src="{{ asset('theme-assets/images/svg/off.svg') }}" alt="">
                                                <span id="{{ $key }}Off" class="position-absolute fontSize10 colorWhite r-0 customOff">20%</span>
                                            </span>
                                            <del id="{{ $key }}PriceBeforeOff" class="customlineText textColor fontSize15">26,900,000</del>
                                        </div>
                                        <div id="{{ $key }}PriceParent" class="fontSize20 hidden">
                                            <span id="{{ $key }}Price"></span>
                                            <span class="fontSize20 colorYellow">ت</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-card-footer mb-2">
                                    <div id="{{ $key }}LauncherParent" class="textColor hidden">
                                        <span class="bold">مکان </span>
                                        <span id="{{ $key }}Launcher"></span>
                                    </div>
                                    <div id="{{ $key }}LauncherParent2" class="textColor hidden">
                                        <span class="bold">برگزار کننده</span>
                                        <span id="{{ $key }}Launcher2"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- end of product-card -->
                        </div>
                    </div>
                </div>
                <!-- If we need pagination -->
                {{-- <div class="swiper-pagination"></div> --}}
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
</div>
<!-- end of box -->


<script>
    
    $(document).ready(function() {
        
        let url = null;
        @if(isset($api))
            url = '{{ $api }}';
        @else
            let query = new URLSearchParams();
            query.append("orderBy", '{{ $searchKey }}');
            query.append("limit", 8);
            url = '{{ route('api.event.list') }}' + '?' + query.toString();
        @endif

        @if (isset($fill_input))
            fetchData(url, "{{ $key }}", "{{ $id }}", "{{ $not_fill_id }}", true);
        @else
            fetchData(url, "{{ $key }}", "{{ $id }}", "{{ $not_fill_id }}");
        @endif
    });

    @if (isset($fill_input))

        $(document).on('click', '.seeAll', function() {
            
            let query = new URLSearchParams();
            
            let selectedTag = $("#allTagsFilter2").val();

            if(selectedTag != "0")
                query.append("tag", selectedTag);

            let url = '{{ route('event.category.list', ['orderBy' => $searchKey]) }}' + '?' + query.toString();
            window.open(url, '_blank').focus();

        });
    
        function changeTag(selectedTag) {
                
            let query = new URLSearchParams();
            query.append("orderBy", '{{ $searchKey }}');
            
            if(selectedTag != "0")
                query.append("tag", selectedTag);

            query.append("limit", 8);
            url = '{{ route('api.event.list') }}' + '?' + query.toString();
        
            fetchData(url, "{{ $key }}", "{{ $id }}", "{{ $not_fill_id }}", true);
        }
    @endif

</script>