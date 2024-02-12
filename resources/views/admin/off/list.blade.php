@extends('admin.layouts.list')

@section('header')
    @parent
    <script src = {{asset("admin-panel/js/calendar.js") }}></script>
    <script src = {{asset("admin-panel/js/calendar-setup.js") }}></script>
    <script src = {{asset("admin-panel/js/calendar-fa.js") }}></script>
    <script src = {{asset("admin-panel/js/jalali.js") }}></script>
    <link rel="stylesheet" href = {{asset("admin-panel/css/calendar-green.css") }}>
    
    <style>
        .calendar table td, .calendar table th {
            min-width: unset !important;
        }
    </style>
@stop

@section('title')
مدیریت تخفیف ها
@stop

@section('preBtn')
    <h3 style="text-align: right">
        جست و جو پیشرفته
        <span data-status="close" style="cursor: pointer; font-size: 16px" id="toggleProSearchBtn" class="glyphicon glyphicon-chevron-down"></span>
    </h3>
@stop

@section('createNew')
'{{ route('off.create') }}'
@stop

@section('items')

<center style="margin-top: 20px">
    
    @if(isset($errors) && $errors != null && count($errors) > 0)
        @foreach ($errors as $error)
            <div>{{$error}}</div>
        @endforeach
    @else

        <div id="pro_search" class="flex margin20 flex-wrap hidden" style="row-gap:30px; column-gap:10px">

            <div class="flex gap10 center">
                <label class="width-auto" for="categoryFilter">دسته</label>
                <select id="categoryFilter">
                    <option value="all">همه</option>
                    @foreach ($categories as $category)
                        <option {{ isset($categoryFilter) && $categoryFilter == $category['id'] ? 'selected' : '' }} value="1">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="sellerFilter">فروشنده</label>
                <select id="sellerFilter">
                    <option value="all">همه</option>
                    @foreach ($sellers as $seller)
                        <option {{ isset($sellerFilter) && $sellerFilter == $seller['id'] ? 'selected' : '' }} value="{{ $seller['id'] }}">{{ $seller['name'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex gap10 center">
                <label class="width-auto" for="brandFilter">برند</label>
                <select id="brandFilter">
                    <option value="all">همه</option>
                    @foreach ($brands as $brand)
                        <option {{ isset($brandFilter) && $brandFilter == $brand['id'] ? 'selected' : '' }} value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="isInTopListFilter">نوع تخفیف</label>
                <select id="offTypeFilter">
                    <option value="all">همه</option>
                    <option {{ isset($offTypeFilter) && $offTypeFilter == 'percent' ? 'selected' : '' }} value="percent">درصدی</option>
                    <option {{ isset($offTypeFilter) && $offTypeFilter == 'value' ? 'selected' : '' }} value="value">مقداری</option>
                </select>
            </div>
            
            <div class="flex gap10 center">
                <label class="width-auto" for="isInTopListFilter">منقضی شده یا نشده</label>
                <select id="expiredFilter">
                    <option value="all">همه</option>
                    <option {{ isset($expiredFilter) && !$expiredFilter ? 'selected' : '' }} value="1">منقضی نشده</option>
                    <option {{ isset($expiredFilter) && $expiredFilter ? 'selected' : '' }} value="0">منقضی شده</option>
                </select>
            </div>
            
            <div class="flex gap10 center">
                <label class="width-auto" for="generalFilter">عمومی یا اختصاصی</label>
                <select id="generalFilter">
                    <option value="all">همه</option>
                    <option {{ isset($generalFilter) && $generalFilter ? 'selected' : '' }} value="1">عمومی</option>
                    <option {{ isset($generalFilter) && !$generalFilter ? 'selected' : '' }} value="0">اختصاصی</option>
                </select>
            </div>
            
            <div class="flex gap10" style="width: 100%">
                 <div class="flex gap10 center">
                    <label class="width-auto" for="fromExpiration">شروع بازه تاریخ انقضا</label>
                    <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="fromExpirationBtn">
                    <input value="{{ isset($fromExpiration) ? $fromExpiration : '' }}" name="fromExpiration" type="text" id="fromExpiration" readonly>
                    <script>
                        Calendar.setup({
                            inputField: "fromExpiration",
                            button: "fromExpirationBtn",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>

                <div class="flex gap10 center">
                    <label class="width-auto" for="toExpiration">اتمام بازه تاریخ انقضا</label>
                    <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="toExpirationBtn">
                    <input value="{{ isset($toExpiration) ? $toExpiration : '' }}" name="toExpiration" type="text" id="toExpiration" readonly>
                    <script>
                        Calendar.setup({
                            inputField: "toExpiration",
                            button: "toExpirationBtn",
                            ifFormat: "%Y/%m/%d",
                            dateType: "jalali"
                        });
                    </script>
                </div>
                
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="orderBy">مرتب سازی بر اساس</label>
                <select id="orderBy">
                    <option {{ isset($orderBy) && $orderBy == 'createdAt' ? 'selected' : '' }} value="createdAt">زمان ایجاد</option>
                    <option {{ isset($orderBy) && $orderBy == 'expiredAt' ? 'selected' : '' }} value="expiredAt">تاریخ انقضا</option>
                </select>
            </div>

            <div class="flex gap10 center">
                <label class="width-auto" for="orderByType">نوع مرتب سازی</label>
                <select id="orderByType">
                    <option {{ isset($orderByType) && $orderByType == 'asc' ? 'selected' : '' }} value="asc">صعودی</option>
                    <option {{ isset($orderByType) && $orderByType == 'desc' ? 'selected' : '' }} value="desc">نزولی</option>
                </select>
            </div>

            <div>
                <button onclick="filter()" class="btn btn-success">اعمال فیلتر</button>
            </div>
            
        </div>
        <table  id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عملیات</th>
                    <th>مقدار</th>
                    <th>نوع</th>
                    <th>تاریخ انقضا</th>
                    <th>تاریخ ایجاد</th>
                    <th>کاربر</th>
                    <th>دسته</th>
                    <th>برند</th>
                    <th>فروشنده</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($items as $item)
                    <tr id="item_{{ $item['id'] }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            <div class="flex flex-col gap10">
                                <div class="flex gap10">
                                    <button data-toggle='tooltip' title="ویرایش" onclick="document.location.href = '{{ route('product.edit', ['product' => $item['id']]) }}'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>
                                    <button data-toggle='tooltip' title="استفاده کنندگان" onclick="document.location.href = '{{ route('product.productGallery.index', ['product' => $item['id']]) }}'" class="btn btn-success"><span class="glyphicon glyphicon-user"></span></button>
                                    <button onclick="removeModal('item', {{$item['id']}}, '{{ route('off.destroy', ['off' => $item['id']]) }}')" data-toggle='tooltip' title="حذف" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                </div>
                            </div>
                            
                        </td>
                        <td>{{ $item['amount'] }}</td>
                        <td>{{ $item['off_type'] }}</td>
                        <td>{{ $item['off_expiration'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td>{{ $item['user'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>{{ $item['brand'] }}</td>
                        <td>{{ $item['seller'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $links !!}
    @endif
    
</center>

<script src="{{ asset('admin-panel/js/pro_search.js') }}"></script>
    <script>

        function filter() {

            let query = new URLSearchParams();
            
            let generalFilter = $("#generalFilter").val();
            let brand = $("#brandFilter").val();
            let category = $("#categoryFilter").val();
            let seller = $("#sellerFilter").val();
            let orderBy = $("#orderBy").val();
            let orderByType = $("#orderByType").val();
            let offTypeFilter = $("#offTypeFilter").val();
            let expiredFilter = $("#expiredFilter").val();
                
            if(offTypeFilter !== 'all')
                query.append('type', offTypeFilter);
                
            if(expiredFilter !== 'all')
                query.append('expired', expiredFilter);

            if(generalFilter !== 'all')
                query.append('general', generalFilter);
                
            if(brand !== 'all')
                query.append('brand', brand);

            if(category !== 'all')
                query.append('category', category);

            query.append('orderBy', orderBy);
            query.append('orderByType', orderByType);

            document.location.href = '{{ route('off.index') }}' + '?' + query.toString();
        }

    </script>

@stop
