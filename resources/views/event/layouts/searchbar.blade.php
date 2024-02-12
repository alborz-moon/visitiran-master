@section('header')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('theme-assets/bootstrap-datepicker.css?v=1') }}">
    <script src="{{ URL::asset('theme-assets//bootstrap-datepicker.js') }}"></script>
@stop

<div class="w-100 backgroundWhite marginTopNegative5 {{ isset($forMarginTop) && $forMarginTop ? '' : 'mb-5' }} ">
    <div class="container pb-1 pt-3">
        <span class="ui-box-title fontSize20 mb-3 {{ isset($forList) && $forList ? 'd-none' : 'mb-5' }}">
            <img class="p-2" src="http://myshop.com/./theme-assets/images/svg/headlineTitle.svg" alt="">
            رویداد خود را بیابید
        </span>
        <div class="row {{ isset($forList) && $forList ? '' : 'mb-5' }}">
            <div class="col-xs-12 col-md-2 marginBottom5">
                <select class="select2 seachbar-select" placeholder="" id="tagFilter">
                    <option selected value="0">موضوع رویداد</option>
                    @if (isset($eventTags))
                        @foreach ($eventTags as $tag)
                            <option value="{{ $tag['name'] }}">
                                {{ $tag['name'] }}</option>
                        @endforeach
                    @else
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->label }}">
                                {{ $tag->label }}</option>
                        @endforeach
                    @endif

                </select>
            </div>
            <div class="col-xs-12 col-md-2 marginBottom5">
                <select class="select2 seachbar-select" aria-placeholder="" id="launcherFilter">
                    <option selected value="0">برگزار کننده</option>
                    @foreach ($launchers as $launcher)
                        <option value="{{ $launcher->id }}">{{ $launcher->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-12 col-md-2 marginBottom5">
                <select class="select2 seachbar-select" aria-placeholder="" id="cityFilter">
                    <option selected value="0">محل برگزاری</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xs-12 col-md-4 marginBottom5">
                <label class="tripCalenderSection w-100">
                    <span class="calendarIcon"></span>
                    <input id="date_input_start" class="tripDateInput form-control customBackgroundWhite w-100"
                        placeholder="تاریخ برگزاری" required readonly type="text">
                </label>
            </div>
            <div class="col-xs-12 col-md-2 marginBottom5">
                <button onclick="goToListPage()" class="btn btn-primary whiteSpaceNoWrap w-100">جست و جو</button>
            </div>
        </div>
    </div>
</div>


<input id="date_input_start_formatted" type="hidden" />

<script>
    var datePickerOptions = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "DD d M سال yy",
        altFormat: "yy/mm/dd",
        altField: $("#date_input_start_formatted")
    };

    $("#date_input_start").datepicker(datePickerOptions);

    function goToListPage() {

        let query = new URLSearchParams();

        let tag = $('#tagFilter').val();
        let launcher = $('#launcherFilter').val();
        let city = $('#cityFilter').val();

        if (tag != 0)
            query.append('tag', tag);

        if (launcher != 0)
            query.append('launcher', launcher);

        if (city != 0)
            query.append('city', city);

        document.location.href = '{{ route('event.category.list', ['orderBy' => 'createdAt']) }}' + "?" + query
            .toString();
    }
</script>
