<!-- start of box -->
<div id="{{ $id }}" class="w-100 my-slider mb-5 hidden">
    <div class="container">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20 d-flex">
                <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}"
                    alt="">{{ $title }}
            </span>

            <span class="alignItemsCenter colorBlue">
                @if (isset($href))
                    <a class="hoverBold" target="_blank" href="{{ isset($href) ? $href : '' }}">
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
                            @include('event.layouts.launcher-card')
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
        @if (isset($api))
            url = '{{ $api }}';
        @else
            let query = new URLSearchParams();
            query.append("orderBy", '{{ $searchKey }}');
            query.append("limit", 8);
            url = '{{ route('api.event.list') }}' + '?' + query.toString();
        @endif

        @if (isset($fill_input))
            fetchLaunchers(url, "{{ $key }}", "{{ $id }}", "{{ $not_fill_id }}", true);
        @else
            fetchLaunchers(url, "{{ $key }}", "{{ $id }}", "{{ $not_fill_id }}");
        @endif
    });
</script>
