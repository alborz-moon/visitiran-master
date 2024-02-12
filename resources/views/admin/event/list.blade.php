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
مدیریت رویدادها
@stop

@section('preBtn')

    <h3 style="text-align: right">
        جست و جو پیشرفته
        <span data-status="close" style="cursor: pointer; font-size: 16px;" id="toggleProSearchBtn" class="glyphicon glyphicon-chevron-down"></span>
    </h3>

@stop

@section('createNew')
'{{ route('create-event') }}'
@stop


@section('items')

<center style="margin-top: 20px">

    <div id="pro_search" class="flex margin20 flex-wrap hidden"  style="row-gap:30px; column-gap:10px">
        <div class="flex gap10 center">
            <label class="width-auto" for="statusFilter">وضعیت</label>
            <select id="statusFilter">
                <option value="all">همه</option>
                <option {{ isset($statusFilter) && $statusFilter == 'confirmed' ? 'selected' : '' }} value="confirmed">تایید شده</option>
                <option {{ isset($statusFilter) && $statusFilter == 'pending' ? 'selected' : '' }} value="pending">در حال بررسی</option>
                <option {{ isset($statusFilter) && $statusFilter == 'rejected' ? 'selected' : '' }} value="rejected">رد شده</option>
            </select>
        </div>

        <div class="flex gap10 center">
            <label class="width-auto" for="typeFilter">نوع رویداد</label>
            <select id="typeFilter">
                <option value="all">همه</option>
                <option {{ isset($typeFilter) && $typeFilter == 'online' ? 'selected' : '' }} value="online">آنلاین</option>
                <option {{ isset($typeFilter) && $typeFilter == 'offline' ? 'selected' : '' }} value="offline">آفلاین</option>
            </select>
        </div>

        <div class="flex gap10 center">
            <label class="width-auto" for="launcherFilter">برگزارکننده</label>
            <select id="launcherFilter">
                <option value="all">همه</option>
                @foreach ($launchers as $launcher)
                    <option {{ isset($launcherFilter) && $launcherFilter == $launcher->id ? 'selected' : '' }} value="{{ $launcher->id }}">{{ $launcher->company_name }}</option>    
                @endforeach
            </select>
        </div>
        
        <div class="flex gap10 center">
            <label class="width-auto" for="tagFilter">موضوع</label>
            <select id="tagFilter">
                <option value="all">همه</option>
                @foreach ($tags as $tag)
                    <option {{ isset($tagFilter) && $tagFilter == $tag->label ? 'selected' : '' }} value="{{ $tag->label }}">{{ $tag->label }}</option>    
                @endforeach
            </select>
        </div>

        
        <div class="flex gap10 center">
            <label class="width-auto" for="orderBy">مرتب سازی بر اساس</label>
            <select id="orderBy">
                <option {{ isset($orderBy) && $orderBy == 'createdAt' ? 'selected' : '' }} value="createdAt">زمان ایجاد</option>
                <option {{ isset($orderBy) && $orderBy == 'rate' ? 'selected' : '' }} value="rate">محبوبیت</option>
                <option {{ isset($orderBy) && $orderBy == 'seen' ? 'selected' : '' }} value="seen">بازدید</option>
                <option {{ isset($orderBy) && $orderBy == 'price' ? 'selected' : '' }} value="price">قیمت</option>
                <option {{ isset($orderBy) && $orderBy == 'rate_count' ? 'selected' : '' }} value="rate_count">تعداد رای</option>
                <option {{ isset($orderBy) && $orderBy == 'comment_count' ? 'selected' : '' }} value="comment_count">تعداد نظرات</option>
                <option {{ isset($orderBy) && $orderBy == 'new_comment_count' ? 'selected' : '' }} value="new_comment_count">تعداد نظرات تایید نشده</option>
                <option {{ isset($orderBy) && $orderBy == 'priority' ? 'selected' : '' }} value="priority">اولویت</option>
            </select>
        </div>
            
        <div class="flex gap10 center">
            <label class="width-auto" for="orderByType">نوع مرتب سازی</label>
            <select id="orderByType">
                <option {{ isset($orderByType) && $orderByType == 'asc' ? 'selected' : '' }} value="asc">صعودی</option>
                <option {{ isset($orderByType) && $orderByType == 'desc' ? 'selected' : '' }} value="desc">نزولی</option>
            </select>
        </div>

        <div class="flex gap10 center">
            <label class="width-auto" for="visibilityFilter">وضعیت نمایش</label>
            <select id="visibilityFilter">
                <option value="all">همه</option>
                <option {{ isset($visibilityFilter) && $visibilityFilter ? 'selected' : '' }} value="1">فعال</option>
                <option {{ isset($visibilityFilter) && !$visibilityFilter ? 'selected' : '' }} value="0">غیرفعال</option>
            </select>
        </div>

        <div class="flex gap10 center">
            <label class="width-auto" for="isInTopListFilter">آیا در صفحه نخست نمایش داده شود؟</label>
            <select id="isInTopListFilter">
                <option value="all">همه</option>
                <option {{ isset($isInTopListFilter) && $isInTopListFilter ? 'selected' : '' }} value="1">بله</option>
                <option {{ isset($isInTopListFilter) && !$isInTopListFilter ? 'selected' : '' }} value="0">خیر</option>
            </select>
        </div>

        <div class="flex gap10" style="width: 100%">
            <div class="flex gap10 center">
                <label class="width-auto" for="fromCreatedAt">شروع بازه تاریخ ایجاد</label>
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="fromCreatedAtBtn">
                <input value="{{ isset($fromCreatedAtFilter) ? $fromCreatedAtFilter : '' }}" name="fromCreatedAt" type="text" id="fromCreatedAt" readonly>
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
                <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="toCreatedAtBtn">
                <input value="{{ isset($toCreatedAtFilter) ? $toCreatedAtFilter : '' }}" name="toCreatedAt" type="text" id="toCreatedAt" readonly>
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

    <p>تعداد کل: {{ count($items) }}</p>
    
    <table id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عملیات</th>
                <th>وضعیت</th>
                <th>عنوان</th>
                <th>موضوع</th>
                <th>نامک</th>
                <th>برگزارکننده</th>
                <th>نوع رویداد</th>
                <th>وضعیت نمایش</th>
                <th>شهر</th>
                <th>بازه ثبت نام</th>
                <th>قیمت</th>
                <th>تعداد خریداران</th>
                <th>اولویت</th>
                <th>آیا در صفحه نخست نمایش داده شود؟</th>
                <th>امتیاز</th>
                <th>تعداد کامنت</th>
                <th>تعداد بازدید</th>
                <th>تاریخ ایجاد</th>
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
                                <a target="_blank" data-toggle='tooltip' title="ویرایش" href="{{ route('update-event', ['event' => $item['id']]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                                {{-- <button data-toggle='tooltip' title="مدیریت رویدادها" onclick="document.location.href = '{{ route('event.index', ['product' => $item['id']]) }}'" class="btn btn-info"><span class="glyphicon glyphicon-list"></span></button> --}}
                                <button data-toggle='tooltip' title="مدیریت نظرات" onclick="document.location.href = '{{ route('event.event_comment.index', ['event' => $item['id']]) }}'" class="btn btn-purple"><span class="glyphicon glyphicon-comment"></span></button>
                                <button onclick="removeModal('item', {{$item['id']}}, '{{ route('event.destroy', ['event' => $item['id']]) }}')" data-toggle='tooltip' title="حذف" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                
                            </div>
                            
                            <div class="flex gap10">
                                <button data-toggle='tooltip' title="مدیریت نظرات" onclick="document.location.href = '{{ route('product.comment.index', ['product' => $item['id']]) }}'" style="background-color: #ce9243; border-color: #ce9243;" class="btn btn-success"><span class="glyphicon glyphicon-stats"></span></button>
                            </div>
                        </div>
                        
                    </td>
                    <td>
                        <p id="status_text_{{ $item['id'] }}">{{ $item['status'] == 'pending' ? "در حال بررسی" : ($item['status'] == 'confirmed' ? "تایید شده" : "رد شده")}}</p>
                        @if($item['status'] == 'pending')
                            <button class="btn btn-success changeStatusBtn" data-value='confirmed' data-id='{{ $item['id'] }}' id="status_confirmed_{{ $item['id'] }}">تایید شده</button>
                            <button class="btn btn-danger changeStatusBtn" data-value='rejected' data-id='{{ $item['id'] }}' id="status_rejected_{{ $item['id'] }}">رد شده</button>
                            <button class="hidden btn btn-primary changeStatusBtn" data-value='pending' data-id='{{ $item['id'] }}' id="status_pending_{{ $item['id'] }}">در حال بررسی</button>
                        @elseif($item['status'] == 'confirmed')
                            <button class="hidden btn btn-success changeStatusBtn" data-value='confirmed' data-id='{{ $item['id'] }}' id="status_confirmed_{{ $item['id'] }}">تایید شده</button>
                            <button class="btn btn-danger changeStatusBtn" data-value='rejected' data-id='{{ $item['id'] }}' id="status_rejected_{{ $item['id'] }}">رد شده</button>
                            <button class="btn btn-primary changeStatusBtn" data-value='pending' data-id='{{ $item['id'] }}' id="status_pending_{{ $item['id'] }}">در حال بررسی</button>
                        @else
                            <button class="btn btn-success changeStatusBtn" data-value='confirmed' data-id='{{ $item['id'] }}' id="status_confirmed_{{ $item['id'] }}">تایید شده</button>
                            <button class="hidden btn btn-danger changeStatusBtn" data-value='rejected' data-id='{{ $item['id'] }}' id="status_rejected_{{ $item['id'] }}">رد شده</button>
                            <button class="btn btn-primary changeStatusBtn" data-value='pending' data-id='{{ $item['id'] }}' id="status_pending_{{ $item['id'] }}">در حال بررسی</button>
                        @endif
                    </td>
                    
                    <td>{{ $item['title'] }}</td>
                    <td>{{ $item['tags'] }}</td>
                    <td>{{ $item['slug'] }}</td>
                    <td>{{ $item['launcher'] }}</td>
                    <td>{{ $item['type'] == 'offline' ? 'آفلاین' : 'آنلاین' }}</td>
                    <td>{{ $item['visibility'] ? 'فعال' : 'غیرفعال' }}</td>
                    <td>{{ $item['city'] }}</td>
                    <td>{{ $item['registry'] }}</td>
                    <td>{{ $item['price'] }}</td>
                    <td>{{ $item['buyers'] }}</td>
                    <td>{{ $item['priority'] }}</td>
                    <td>
                        <p id="is_in_top_list_text_{{ $item['id'] }}">{{ $item['is_in_top_list'] == 1 ? 'بله' : 'خیر' }}</p>
                        @if($item['is_in_top_list'] == 1)
                            <button class="btn btn-danger changeIsInTopListBtn" data-value='remove' data-id='{{ $item['id'] }}' id="is_in_top_list_remove_{{ $item['id'] }}">حذف از برترینها</button>
                            <button class="hidden btn btn-success changeIsInTopListBtn" data-value='add' data-id='{{ $item['id'] }}' id="is_in_top_list_add_{{ $item['id'] }}">افزودن به برترینها</button>
                        @else
                            <button class="hidden btn btn-danger changeIsInTopListBtn" data-value='remove' data-id='{{ $item['id'] }}' id="is_in_top_list_remove_{{ $item['id'] }}">حذف از برترینها</button>
                            <button class="btn btn-success changeIsInTopListBtn" data-value='add' data-id='{{ $item['id'] }}' id="is_in_top_list_add_{{ $item['id'] }}">افزودن به برترینها</button>
                        @endif
                    </td>
                    <td>{{ $item['rate'] == null ? 'امتیازی ثبت نشده است' : $item['rate'] . ' از ' . $item['rate_count'] . ' رای'}}</td>
                    <td>{{ $item['comment_count'] == 0 ? 'کامنتی ثبت نشده است' : 'تعداد کل: ' . $item['comment_count'] . ' تعداد تایید نشده:' . $item['new_comment_count'] }}</td>
                    
                    <td>{{ $item['seen'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</center>

<script src="{{ asset('admin-panel/js/pro_search.js') }}"></script>

    <script>
        
        $(document).on('click', '.changeStatusBtn', function() {
            changeStatus($(this).attr('data-id'), $(this).attr('data-value'));
        });

            
        $(document).on('click', '.changeIsInTopListBtn', function() {
            changeIsInTopList($(this).attr('data-id'), $(this).attr('data-value'));
        });

        function changeIsInTopList(eventId, newStatus) {
            $.ajax({
                type: 'post',
                url: '{{ route('event.changeIsInTopList') }}',
                data: {
                    'event_id': eventId
                },
                success: function(res) {

                    if(res.status === "ok") {
                        if(newStatus == 'add') {
                            $("#is_in_top_list_remove_" + eventId).removeClass('hidden');
                            $("#is_in_top_list_add_" + eventId).addClass('hidden');
                            $("#is_in_top_list_text_" + eventId).text('بله');
                        }
                        else {
                            $("#is_in_top_list_remove_" + eventId).addClass('hidden');
                            $("#is_in_top_list_add_" + eventId).removeClass('hidden');
                            $("#is_in_top_list_text_" + eventId).text('خیر');
                        }
                        showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                    }
                    else {
                        showErr(res.msg);
                    }
                }
            });
        }
        
        function changeStatus(eventId, newStatus) {
            $.ajax({
                type: 'post',
                url: '{{ route('event.changeStatus') }}',
                data: {
                    'status': newStatus,
                    'event_id': eventId
                },
                success: function(res) {

                    if(res.status === "ok") {
                        if(newStatus == 'pending') {
                            $("#status_confirmed_" + eventId).removeClass('hidden');
                            $("#status_rejected_" + eventId).removeClass('hidden');
                            $("#status_pending_" + eventId).addClass('hidden');
                            $("#status_text_" + eventId).text('در حال بررسی');
                        }
                        else if(newStatus == 'confirmed') {
                            $("#status_confirmed_" + eventId).addClass('hidden');
                            $("#status_rejected_" + eventId).removeClass('hidden');
                            $("#status_pending_" + eventId).removeClass('hidden');
                            $("#status_text_" + eventId).text('تایید شده');
                        }
                        else {
                            $("#status_confirmed_" + eventId).removeClass('hidden');
                            $("#status_pending_" + eventId).removeClass('hidden');
                            $("#status_rejected_" + eventId).addClass('hidden');
                            $("#status_text_" + eventId).text('رد شده');
                        }
                        showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                    }
                    else {
                        showErr(res.msg);
                    }
                }
            });
        }

        function buildQuery() {
            
            let query = new URLSearchParams();
            let launcher = $("#launcherFilter").val();
            let tag = $("#tagFilter").val();
            let type = $("#typeFilter").val();
            let visibility = $("#visibilityFilter").val();
            let status = $("#statusFilter").val();
            let isInTopList = $("#isInTopListFilter").val();
            // let comment = $("#commentFilter").val();
            let orderBy = $("#orderBy").val();
            let orderByType = $("#orderByType").val();

            let toCreatedAt = $("#toCreatedAt").val();
            let fromCreatedAt = $("#fromCreatedAt").val();
            
            let toAt = $("#toAt").val();
            let fromAt = $("#fromAt").val();

            if(visibility !== 'all')
                query.append('visibility', visibility);
                
            if(status !== 'all')
                query.append('status', status);
                
            if(isInTopList !== 'all')
                query.append('isInTopList', isInTopList);
                
            if(launcher !== 'all')
                query.append('launcher', launcher);
                
            if(tag !== 'all')
                query.append('tag', tag);
                
            if(type !== 'all')
                query.append('type', type);
                
            if(status !== 'all')
                query.append('status', status);

            // if(comment !== 'all')
            //     query.append('comment', comment);
                
            if(toCreatedAt !== '')
                query.append('toCreatedAt', toCreatedAt);
                
            if(fromCreatedAt !== '')
                query.append('fromCreatedAt', fromCreatedAt);

            query.append('orderBy', orderBy);
            query.append('orderByType', orderByType);

            return query;
        }

        function filter() {
            document.location.href = '{{ route('event.index') }}' + '?' + buildQuery().toString();
        }
    

    </script>

@stop
