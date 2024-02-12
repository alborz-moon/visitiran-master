@extends('admin.layouts.list')

@section('header')
    @parent
@stop

@section('title')
مدیریت کاربران - {{ $levelFa }}
@stop

@section('preBtn')
    <h3 style="text-align: right">
        جست و جو پیشرفته
        <span data-status="close" style="cursor: pointer; font-size: 16px" id="toggleProSearchBtn" class="glyphicon glyphicon-chevron-down"></span>
    </h3>
@stop

@section('createNew')
'{{ route('users.create', ['level' => $level]) }}'
@stop

@section('items')

<center style="margin-top: 20px">
    
    <p>تعداد کل: {{ count($items) }}</p>

    <div id="pro_search" class="flex margin20 flex-wrap hidden" style="row-gap:30px; column-gap:10px">
        <div class="flex gap10 center">
            <label class="width-auto" for="statusFilter">وضعیت</label>
            <select id="statusFilter">
                <option value="all">همه</option>
                <option {{ isset($statusFilter) && $statusFilter == 'active' ? 'selected' : '' }} value="active">فعال</option>
                <option {{ isset($statusFilter) && $statusFilter == 'init' ? 'selected' : '' }} value="init">غیرفعال</option>
            </select>
        </div>

        <div class="flex gap10 center">
            <label class="width-auto" for="accessFilter">اجازه دسترسی</label>
            <select id="accessFilter">
                <option value="all">همه</option>
                <option {{ isset($accessFilter) && $accessFilter == 'both' ? 'selected' : '' }} value="both">هر دو سایت</option>
                <option {{ isset($accessFilter) && $accessFilter == 'event' ? 'selected' : '' }} value="event">فقط سایت ایونت</option>
                <option {{ isset($accessFilter) && $accessFilter == 'shop' ? 'selected' : '' }} value="shop">فقط سایت فروشگاه</option>
            </select>
        </div>

        <div>
            <button onclick="filter()" class="btn btn-success">اعمال فیلتر</button>
        </div>
        
    </div>

    <table id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عملیات</th>
                <th>نام</th>
                <th>کد ملی</th>
                <th>شماره تماس</th>
                <th>ایمیل</th>
                <th>اجازه دسترسی</th>
                <th>وضعیت</th>
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
                                <a target="_blank" data-toggle='tooltip' title="ویرایش" href="{{ route('users.edit', ['user' => $item['id'], 'level' => $level]) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <button onclick="removeModal('item', {{$item['id']}}, '{{ route('users.destroy', ['user' => $item['id']]) }}')" data-toggle='tooltip' title="حذف" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>    
                            </div>
                        </div>
                        
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['nid'] }}</td>
                    <td>{{ $item['phone'] }}</td>
                    <td>{{ $item['mail'] }}</td>

                    <td>{{ $item['access_fa'] }}</td>
                    
                    <td>
                        <p id="status_text_{{ $item['id'] }}">{{ $item['status'] == 'active' ? "فعال" : "غیرفعال"}}</p>
                        @if($item['status'] == 'active')
                            <button class="hidden btn btn-success changeStatusBtn" data-value='active' data-id='{{ $item['id'] }}' id="status_active_{{ $item['id'] }}">فعال</button>
                            <button class="btn btn-danger changeStatusBtn" data-value='init' data-id='{{ $item['id'] }}' id="status_init_{{ $item['id'] }}">غیرفعال</button>
                        @else
                            <button class="btn btn-success changeStatusBtn" data-value='active' data-id='{{ $item['id'] }}' id="status_active_{{ $item['id'] }}">فعال</button>
                            <button class="hidden btn btn-danger changeStatusBtn" data-value='init' data-id='{{ $item['id'] }}' id="status_init_{{ $item['id'] }}">غیرفعال</button>
                        @endif
                    </td>
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


        function changeStatus(userId, newStatus) {
            
            $.ajax({
                type: 'post',
                url: '{{ route('users.change') }}',
                data: {
                    'status': newStatus,
                    'user_id': userId
                },
                success: function(res) {

                    if(res.status === "ok") {
                        if(newStatus == 'active') {
                            $("#status_active_" + userId).addClass('hidden');
                            $("#status_init_" + userId).removeClass('hidden');
                            $("#status_text_" + userId).text('فعال');
                        }
                        else {
                            $("#status_active_" + userId).removeClass('hidden');
                            $("#status_init_" + userId).addClass('hidden');
                            $("#status_text_" + userId).text('غیرفعال');
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
            
            let access = $("#accessFilter").val();
            let status = $("#statusFilter").val();

            if(access !== 'all')
                query.append('access', access);
                
            if(status !== 'all')
                query.append('status', status);
                
            return query;
        }

        function filter() {
            document.location.href = '{{ route('users.index', ['level' => $level]) }}' + "&" + buildQuery().toString();
        }
    

    </script>

@stop
