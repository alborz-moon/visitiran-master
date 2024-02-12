@extends('admin.layouts.create')

@section('header')
    @parent
    <script src={{ asset('admin-panel/js/calendar.js') }}></script>
    <script src={{ asset('admin-panel/js/calendar-setup.js') }}></script>
    <script src={{ asset('admin-panel/js/calendar-fa.js') }}></script>
    <script src={{ asset('admin-panel/js/jalali.js') }}></script>
    <link rel="stylesheet" href={{ asset('admin-panel/css/calendar-green.css') }}>

    <style>
        .calendar table td,
        .calendar table th {
            min-width: unset !important;
        }
    </style>
@stop

@section('title')
    {{ isset($item) ? 'ویرایش تخفیف' : 'افزودن تخفیف' }}
@stop

@section('form')

    <form id="myForm" action="{{ isset($item) ? route('off.update', ['off' => $item['id']]) : route('off.store') }}"
        method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="off_type">نوع تخفیف</label>
                <select name="off_type" required id="off_type">
                    <option {{ isset($item) && $item['off_type'] == 'percent' ? 'selected' : '' }} value="percent">درصدی
                    </option>
                    <option {{ isset($item) && $item['off_type'] == 'value' ? 'selected' : '' }} value="value">مقداری
                    </option>
                </select>
            </div>

            <div>
                <label for="amount">مقدار</label>
                <input required value="{{ isset($item) ? $item['amount'] : '' }}" type="number" name="amount"
                    id="amount" />
            </div>

            <div>
                <label>
                    تاریخ انقضا
                    <input type="button"
                        style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                        id="date_btn">

                </label>
                <input value="{{ isset($item) ? $item['off_expiration'] : '' }}" name="off_expiration" type="text"
                    id="date_input" readonly>
                <script>
                    Calendar.setup({
                        inputField: "date_input",
                        button: "date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>

            <div>
                <label for="code">کد (اختیاری)</label>
                <input value="{{ isset($item) ? $item['code'] : '' }}" type="text" name="code" id="code" />
            </div>

            <div>
                <label for="is_general">آیا کد تخفیف عمومی است؟</label>
                <select
                    onchange="if($(this).val() === 'yes') $('#userInfoSection').addClass('hidden'); else $('#userInfoSection').removeClass('hidden');"
                    id="is_general">
                    <option value="yes">بله</option>
                    <option value="no">خیر</option>
                </select>
            </div>

            <div id="userInfoSection" class="hidden">
                <label for="username">شماره همراه کاربر مدنظر</label>
                <input value="{{ isset($item) ? $item['username'] : '' }}" type="text" name="username" id="username" />
            </div>

            @if (request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)

                <div>
                    <label for="category_id">دسته موردنظر</label>
                    <select name="category_id" id="category_id">
                        <option value="-1">نامشخص</option>
                        @foreach ($categories as $category)
                            <option {{ isset($item) && $item['category_id'] == $category['id'] ? 'selected' : '' }}
                                value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="brand_id">برند موردنظر</label>
                    <select name="brand_id" id="brand_id">
                        <option value="-1">نامشخص</option>
                        @foreach ($brands as $brand)
                            <option {{ isset($item) && $item['brand_id'] == $brand['id'] ? 'selected' : '' }}
                                value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label for="seller_id">فروشنده</label>
                    <select name="seller_id" id="seller_id">
                        <option value="-1">نامشخص</option>
                        @foreach ($sellers as $seller)
                            <option {{ isset($item) && $item['seller_id'] == $seller['id'] ? 'selected' : '' }}
                                value="{{ $seller['id'] }}">{{ $seller['name'] }}</option>
                        @endforeach
                    </select>
                </div>

            @endif

        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('off.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop
