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
    مدیریت برگزار کنندگان
@stop

@section('preBtn')
    <h3 style="text-align: right">
        جست و جو پیشرفته
        <span data-status="close" style="cursor: pointer; font-size: 16px" id="toggleProSearchBtn"
            class="glyphicon glyphicon-chevron-down"></span>
    </h3>
@stop

@section('createNew')
    '{{ route('launcher') }}'
@stop

@section('items')

    <center style="margin-top: 20px">


        <p>تعداد کل: {{ count($items) }}</p>

        <div id="pro_search" class="flex margin20 flex-wrap hidden" style="row-gap:30px; column-gap:10px">
            <div class="flex gap10 center">
                <label class="width-auto" for="visibilityFilter">وضعیت</label>
                <select id="visibilityFilter">
                    <option value="all">همه</option>
                    <option {{ isset($statusFilter) && $statusFilter == 'confirmed' ? 'selected' : '' }} value="1">
                        تایید شده</option>
                    <option {{ isset($statusFilter) && $statusFilter == 'pending' ? 'selected' : '' }} value="0">در حال
                        بررسی</option>
                    <option {{ isset($statusFilter) && $statusFilter == 'rejected' ? 'selected' : '' }} value="0">رد
                        شده</option>
                </select>
            </div>


            <div class="flex gap10 center">
                <label class="width-auto" for="orderBy">مرتب سازی بر اساس</label>
                <select id="orderBy">
                    <option {{ isset($orderBy) && $orderBy == 'createdAt' ? 'selected' : '' }} value="createdAt">زمان ایجاد
                    </option>
                    <option {{ isset($orderBy) && $orderBy == 'rate' ? 'selected' : '' }} value="rate">محبوبیت</option>
                    <option {{ isset($orderBy) && $orderBy == 'seen' ? 'selected' : '' }} value="seen">بازدید</option>
                    <option {{ isset($orderBy) && $orderBy == 'price' ? 'selected' : '' }} value="price">قیمت</option>
                    <option {{ isset($orderBy) && $orderBy == 'rate_count' ? 'selected' : '' }} value="rate_count">تعداد
                        رای</option>
                    <option {{ isset($orderBy) && $orderBy == 'comment_count' ? 'selected' : '' }} value="comment_count">
                        تعداد نظرات</option>
                    <option {{ isset($orderBy) && $orderBy == 'new_comment_count' ? 'selected' : '' }}
                        value="new_comment_count">تعداد نظرات تایید نشده</option>
                    <option {{ isset($orderBy) && $orderBy == 'sell_count' ? 'selected' : '' }} value="sell_count">تعداد
                        فروش</option>
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
                    <th>عملیات</th>
                    <th>نام کاربر</th>
                    <th>شماره تماس کاربر</th>
                    <th>نام شرکت</th>
                    <th>نام رابط</th>
                    <th>شماره تماس رابط</th>
                    <th>نوع برگزار کننده</th>
                    <th>امتیاز</th>
                    <th>تعداد کامنت</th>
                    <th>تعداد دنبال کنندگان</th>
                    <th>تعداد رویدادهای تایید شده</th>
                    <th>تعداد رویدادهای جاری</th>
                    <th>وضعیت تاییده برگزارکنندگی</th>
                    <th>وضعیت تاییده کاربری</th>
                    <th>تعداد بازدید</th>
                    <th>تاریخ ایجاد</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($items as $item)
                    <tr id="item_{{ $item['id'] }}">
                        <td>{{ $i++ }}</td>
                        <td>
                            <div class="flex flex-col gap10">
                                <div class="flex gap10">
                                    <a target="_blank" data-toggle='tooltip' title="ویرایش"
                                        href="{{ route('launcher-edit', ['launcher' => $item['id']]) }}"
                                        class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                                    {{-- <button data-toggle='tooltip' title="مدیریت رویدادها" onclick="document.location.href = '{{ route('event.index', ['product' => $item['id']]) }}'" class="btn btn-info"><span class="glyphicon glyphicon-list"></span></button> --}}
                                    <button data-toggle='tooltip' title="مدیریت نظرات"
                                        onclick="document.location.href = '{{ route('launcher.launcher_comment.index', ['launcher' => $item['id']]) }}'"
                                        class="btn btn-purple"><span class="glyphicon glyphicon-comment"></span></button>
                                    <button
                                        onclick="removeModal('item', {{ $item['id'] }}, '{{ route('product.destroy', ['product' => $item['id']]) }}')"
                                        data-toggle='tooltip' title="حذف" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span></button>

                                </div>

                                <div class="flex gap10">
                                    <button data-toggle='tooltip' title="مدیریت نظرات"
                                        onclick="document.location.href = '{{ route('product.comment.index', ['product' => $item['id']]) }}'"
                                        style="background-color: #ce9243; border-color: #ce9243;"
                                        class="btn btn-success"><span class="glyphicon glyphicon-stats"></span></button>
                                </div>
                            </div>

                        </td>
                        <td>{{ $item['user']['name'] }}</td>
                        <td>{{ $item['user']['phone'] }}</td>
                        <td>{{ $item['company_name'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['phone'] }}</td>
                        <td>{{ $item['type'] == 'haghighi' ? 'حقیقی' : 'حقوقی' }}</td>
                        <td>{{ $item['rate'] == null ? 'امتیازی ثبت نشده است' : $item['rate'] . ' از ' . $item['rate_count'] . ' رای' }}
                        </td>

                        <td>{{ $item['comment_count'] == 0 ? 'کامنتی ثبت نشده است' : 'تعداد کل: ' . $item['comment_count'] . ' تعداد تایید نشده:' . $item['new_comment_count'] }}
                        </td>

                        <td>{{ $item['follower_count'] }}</td>
                        <td>{{ $item['confirmed_events_count'] }}</td>
                        <td>{{ $item['active_events'] }}</td>
                        <td>
                            <p id="launcher_status_text_{{ $item['id'] }}">
                                {{ $item['launcher_status'] == 'pending' ? 'در حال بررسی' : ($item['launcher_status'] == 'confirmed' ? 'تایید شده' : 'رد شده') }}
                            </p>
                            @if ($item['launcher_status'] == 'pending')
                                <button class="btn btn-success changeLauncherStatusBtn" data-value='confirmed'
                                    data-id='{{ $item['id'] }}'
                                    id="launcher_status_confirmed_{{ $item['id'] }}">تایید شده</button>
                                <button class="btn btn-danger changeLauncherStatusBtn" data-value='rejected'
                                    data-id='{{ $item['id'] }}' id="launcher_status_rejected_{{ $item['id'] }}">رد
                                    شده</button>
                                <button class="hidden btn btn-primary changeLauncherStatusBtn" data-value='pending'
                                    data-id='{{ $item['id'] }}' id="launcher_status_pending_{{ $item['id'] }}">در
                                    حال بررسی</button>
                            @elseif($item['launcher_status'] == 'confirmed')
                                <button class="hidden btn btn-success changeLauncherStatusBtn" data-value='confirmed'
                                    data-id='{{ $item['id'] }}'
                                    id="launcher_status_confirmed_{{ $item['id'] }}">تایید شده</button>
                                <button class="btn btn-danger changeLauncherStatusBtn" data-value='rejected'
                                    data-id='{{ $item['id'] }}' id="launcher_status_rejected_{{ $item['id'] }}">رد
                                    شده</button>
                                <button class="btn btn-primary changeLauncherStatusBtn" data-value='pending'
                                    data-id='{{ $item['id'] }}' id="launcher_status_pending_{{ $item['id'] }}">در
                                    حال بررسی</button>
                            @else
                                <button class="btn btn-success changeLauncherStatusBtn" data-value='confirmed'
                                    data-id='{{ $item['id'] }}'
                                    id="launcher_status_confirmed_{{ $item['id'] }}">تایید شده</button>
                                <button class="hidden btn btn-danger changeLauncherStatusBtn" data-value='rejected'
                                    data-id='{{ $item['id'] }}' id="launcher_status_rejected_{{ $item['id'] }}">رد
                                    شده</button>
                                <button class="btn btn-primary changeLauncherStatusBtn" data-value='pending'
                                    data-id='{{ $item['id'] }}' id="launcher_status_pending_{{ $item['id'] }}">در
                                    حال بررسی</button>
                            @endif
                        </td>
                        <td>
                            <p id="user_status_text_{{ $item['user']['id'] }}">
                                {{ $item['user_status'] == 'active' ? 'فعال' : 'غیرفعال' }}</p>
                            @if ($item['user_status'] == 'active')
                                <button class="hidden btn btn-success changeUserStatusBtn" data-value='active'
                                    data-id='{{ $item['user']['id'] }}'
                                    id="user_status_active_{{ $item['user']['id'] }}">فعال</button>
                                <button class="btn btn-danger changeUserStatusBtn" data-value='init'
                                    data-id='{{ $item['user']['id'] }}'
                                    id="user_status_init_{{ $item['user']['id'] }}">غیرفعال</button>
                            @else
                                <button class="btn btn-success changeUserStatusBtn" data-value='active'
                                    data-id='{{ $item['user']['id'] }}'
                                    id="user_status_active_{{ $item['user']['id'] }}">فعال</button>
                                <button class="hidden btn btn-danger changeUserStatusBtn" data-value='init'
                                    data-id='{{ $item['user']['id'] }}'
                                    id="user_status_init_{{ $item['user']['id'] }}">غیرفعال</button>
                            @endif
                        </td>
                        <td>{{ $item['seen'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </center>

    <script src="{{ asset('admin-panel/js/pro_search.js') }}"></script>

    <script>
        $(document).on('click', ".saveBtn", function() {
            save($(this).attr('data-id'));
        });

        $(document).on('click', '.changeLauncherStatusBtn', function() {
            changeStatus($(this).attr('data-id'), $(this).attr('data-value'));
        });

        $(document).on('click', '.changeUserStatusBtn', function() {
            changeUserStatus($(this).attr('data-id'), $(this).attr('data-value'));
        });


        function changeStatus(launcherId, newStatus) {
            $.ajax({
                type: 'post',
                url: '{{ route('launcher.changeStatus') }}',
                data: {
                    'status': newStatus,
                    'launcher_id': launcherId
                },
                success: function(res) {

                    if (res.status === "ok") {
                        if (newStatus == 'pending') {
                            $("#launcher_status_confirmed_" + launcherId).removeClass('hidden');
                            $("#launcher_status_rejected_" + launcherId).removeClass('hidden');
                            $("#launcher_status_pending_" + launcherId).addClass('hidden');
                            $("#launcher_status_text_" + launcherId).text('در حال بررسی');
                        } else if (newStatus == 'confirmed') {
                            $("#launcher_status_confirmed_" + launcherId).addClass('hidden');
                            $("#launcher_status_rejected_" + launcherId).removeClass('hidden');
                            $("#launcher_status_pending_" + launcherId).removeClass('hidden');
                            $("#launcher_status_text_" + launcherId).text('تایید شده');
                        } else {
                            $("#launcher_status_confirmed_" + launcherId).removeClass('hidden');
                            $("#launcher_status_pending_" + launcherId).removeClass('hidden');
                            $("#launcher_status_rejected_" + launcherId).addClass('hidden');
                            $("#launcher_status_text_" + launcherId).text('رد شده');
                        }
                        showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                    } else {
                        showErr(res.msg);
                    }
                }
            });
        }


        function changeUserStatus(userId, newStatus) {

            $.ajax({
                type: 'post',
                url: '{{ route('users.change') }}',
                data: {
                    'status': newStatus,
                    'user_id': userId
                },
                success: function(res) {

                    if (res.status === "ok") {
                        if (newStatus == 'active') {
                            $("#user_status_active_" + userId).addClass('hidden');
                            $("#user_status_init_" + userId).removeClass('hidden');
                            $("#user_status_text_" + userId).text('فعال');
                        } else {
                            $("#user_status_active_" + userId).removeClass('hidden');
                            $("#user_status_init_" + userId).addClass('hidden');
                            $("#user_status_text_" + userId).text('غیرفعال');
                        }
                        showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                    } else {
                        showErr(res.msg);
                    }
                }
            });
        }


        function buildQuery() {

            let query = new URLSearchParams();

            let visibility = $("#visibilityFilter").val();
            let isInTopList = $("#isInTopListFilter").val();
            let brand = $("#brandFilter").val();
            let category = $("#categoryFilter").val();
            let seller = $("#sellerFilter").val();
            let off = $("#offFilter").val();
            let comment = $("#commentFilter").val();
            let max = $("#maxFilter").val();
            let min = $("#minFilter").val();
            let orderBy = $("#orderBy").val();
            let orderByType = $("#orderByType").val();

            let toCreatedAt = $("#toCreatedAt").val();
            let fromCreatedAt = $("#fromCreatedAt").val();

            if (visibility !== 'all')
                query.append('visibility', visibility);

            if (isInTopList !== 'all')
                query.append('isInTopList', isInTopList);

            if (brand !== 'all')
                query.append('brand', brand);

            if (category !== 'all')
                query.append('category', category);

            if (seller !== 'all')
                query.append('seller', seller);

            if (max !== '')
                query.append('max', max);

            if (min !== '')
                query.append('min', min);

            if (off !== 'all')
                query.append('off', off);

            if (comment !== 'all')
                query.append('comment', comment);

            if (toCreatedAt !== '')
                query.append('toCreatedAt', toCreatedAt);

            if (fromCreatedAt !== '')
                query.append('fromCreatedAt', fromCreatedAt);

            query.append('orderBy', orderBy);
            query.append('orderByType', orderByType);

            return query;
        }

        function filter() {
            document.location.href = '{{ route('product.index') }}' + '?' + buildQuery().toString();
        }
    </script>

@stop
