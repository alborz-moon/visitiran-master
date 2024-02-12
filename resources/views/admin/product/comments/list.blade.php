@extends('admin.layouts.list')


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
    مدیریت نظرات محصول > {{ $itemName }}
@stop

@section('backBtn')
    <button onclick="document.location.href = '{{ $backRoute }}'" class="btn btn-danger">بازگشت</button>
@stop

@section('addBtn')
@stop

@section('items')
    <center style="margin-top: 20px">

        <p>تعداد کل: {{ $total_count }}</p>

        <h3 style="text-align: right">
            جست و جو پیشرفته
            <span data-status="close" style="cursor: pointer" id="toggleProSearchBtn"
                class="glyphicon glyphicon-chevron-down"></span>
        </h3>
        <div id="pro_search" class="flex gap30 margin20 flex-wrap hidden">
            <div class="flex gap10 center">
                <label class="width-auto" for="confirmedFilter">وضعیت</label>
                <select id="confirmedFilter">
                    <option value="all">همه</option>
                    <option {{ isset($confirmedFilter) && $confirmedFilter ? 'selected' : '' }} value="1">تایید شده
                    </option>
                    <option {{ isset($confirmedFilter) && !$confirmedFilter ? 'selected' : '' }} value="0">تایید نشده
                    </option>
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="rateFilter">وضعیت امتیاز</label>
                <select id="rateFilter">
                    <option value="all">همه</option>
                    <option {{ isset($rateFilter) && !$rateFilter ? 'selected' : '' }} value="0">بدون امتیاز</option>
                    <option {{ isset($rateFilter) && $rateFilter ? 'selected' : '' }} value="1">با امتیاز</option>
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="minFilter">حداقل امتیاز</label>
                <input type="number" value="{{ isset($minFilter) ? $minFilter : '' }}" id="minFilter" />
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="maxFilter">حداکثر امتیاز</label>
                <input type="number" value="{{ isset($maxFilter) ? $maxFilter : '' }}" id="maxFilter" />
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="orderBy">مرتب سازی بر اساس</label>
                <select id="orderBy">
                    <option {{ isset($orderBy) && $orderBy == 'created_at' ? 'selected' : '' }} value="created_at">زمان
                        ایجاد</option>
                    <option {{ isset($orderBy) && $orderBy == 'rate' ? 'selected' : '' }} value="rate">امتیاز</option>
                    <option {{ isset($orderBy) && $orderBy == 'confirmed_at' ? 'selected' : '' }} value="confirmed_at">زمان
                        تایید</option>
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="orderByType">نوع مرتب سازی</label>
                <select id="orderByType">
                    <option {{ isset($orderByType) && $orderByType == 'asc' ? 'selected' : '' }} value="asc">صعودی
                    </option>
                    <option {{ isset($orderByType) && $orderByType == 'desc' ? 'selected' : '' }} value="desc">نزولی
                    </option>
                </select>
            </div>

            <div class="flex gap10" style="width: 100%">
                <div class="flex gap10 center">
                    <label class="width-auto" for="fromCreatedAt">شروع بازه تاریخ ایجاد</label>
                    <input type="button"
                        style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                        id="fromCreatedAtBtn">
                    <input value="{{ isset($fromCreatedAtFilter) ? $fromCreatedAtFilter : '' }}" name="fromCreatedAt"
                        type="text" id="fromCreatedAt" readonly>
                    <script>
                        Calendar.setup({
                            inputField: "fromCreatedAt",
                            button: "fromCreatedAtBtn",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

                <div class="flex gap10 center">
                    <label class="width-auto" for="toCreatedAt">اتمام بازه تاریخ ایجاد</label>
                    <input type="button"
                        style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;"
                        id="toCreatedAtBtn">
                    <input value="{{ isset($toCreatedAtFilter) ? $toCreatedAtFilter : '' }}" name="toCreatedAt"
                        type="text" id="toCreatedAt" readonly>
                    <script>
                        Calendar.setup({
                            inputField: "toCreatedAt",
                            button: "toCreatedAtBtn",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

            </div>

            <div>
                <button onclick="filter()" class="btn btn-success">اعمال فیلتر</button>
            </div>

        </div>


        <table id="table" data-toggle="table" data-search="true" data-show-columns="true" data-key-events="true"
            data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true"
            data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام کاربر</th>
                    <th>شماره همراه</th>
                    <th>امتیاز</th>
                    <th>نظر</th>
                    <th>وضعیت</th>
                    <th>زمان ایجاد</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($items as $item)
                    <tr id="item_{{ $item['id'] }}">

                        <td>{{ $i++ }}</td>
                        <td>{{ $item['user'] }}</td>
                        <td>{{ $item['phone'] }}</td>
                        <td>{{ $item['rate'] == null ? 'رای داده نشده' : $item['rate'] }}</td>
                        <td>{{ $item['msg'] == null ? 'نظری ثبت نشده' : substr($item['msg'], 0, Str::length($item['msg']) > 30 ? 30 : Str::length($item['msg'])) . ' ...' }}
                        </td>
                        <td>{{ $item['status'] ? 'تایید شده' : 'تایید نشده' }}</td>
                        <td>{{ $item['created_at'] }}</td>

                        <td>
                            <button data-toggle='tooltip' title="نمایش متن کامل نظر"
                                onclick="document.location.href = '{{ $item['editUrl'] }}'" class="btn btn-primary"><span
                                    class="glyphicon glyphicon-eye-open"></span></button>
                            <button onclick="removeModal('item', {{ $item['id'] }}, '{{ $item['destroyUrl'] }}')"
                                data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                    class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script src="{{ asset('admin-panel/js/pro_search.js') }}"></script>


        <script>
            function buildQuery() {

                let query = new URLSearchParams();

                let confirmed = $("#confirmedFilter").val();
                let rate = $("#rateFilter").val();

                let max = $("#maxFilter").val();
                let min = $("#minFilter").val();

                let orderBy = $("#orderBy").val();
                let orderByType = $("#orderByType").val();

                let toCreatedAt = $("#toCreatedAt").val();
                let fromCreatedAt = $("#fromCreatedAt").val();

                if (confirmed !== 'all')
                    query.append('confirmed', confirmed);

                if (rateFilter !== 'all')
                    query.append('rate', rate);

                if (max !== '')
                    query.append('max', max);

                if (min !== '')
                    query.append('min', min);

                if (toCreatedAt !== '')
                    query.append('toCreatedAt', toCreatedAt);

                if (fromCreatedAt !== '')
                    query.append('fromCreatedAt', fromCreatedAt);

                query.append('orderBy', orderBy);
                query.append('orderByType', orderByType);

                return query;
            }

            function filter() {
                document.location.href = '{{ $refreshRoute }}' + '?' + buildQuery().toString();
            }
        </script>

    @stop
