@extends('admin.layouts.list')

@section('title')
کاربران خبرنامه
@stop

@section('items')

<center style="margin-top: 20px">
    
    @if(isset($errors) && $errors != null && count($errors) > 0)
        @foreach ($errors as $error)
            <div>{{$error}}</div>
        @endforeach
    @else

        <h3 style="text-align: right">
            جست و جو پیشرفته
            <span data-status="close" style="cursor: pointer" id="toggleProSearchBtn" class="glyphicon glyphicon-chevron-down"></span>
        </h3>
        
        <div id="pro_search" class="flex gap30 margin20 flex-wrap hidden">

            <div class="flex gap10" style="width: 100%">
                 <div class="flex gap10 center">
                    <label class="width-auto" for="fromCreatedAt">شروع بازه تاریخ ایجاد</label>
                    <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="fromCreatedAtBtn">
                    <input value="{{ isset($fromCreatedAt) ? $fromCreatedAt : '' }}" name="fromCreatedAt" type="text" id="fromCreatedAt" readonly>
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
                    <input value="{{ isset($toCreatedAt) ? $toCreatedAt : '' }}" name="toCreatedAt" type="text" id="toCreatedAt" readonly>
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

            <div class="flex gap10 center">
                <label class="width-auto" for="orderBy">مرتب سازی بر اساس</label>
                <select id="orderBy">
                    <option {{ isset($orderBy) && $orderBy == 'createdAt' ? 'selected' : '' }} value="createdAt">زمان ایجاد</option>
                    <option {{ isset($orderBy) && $orderBy == 'rate' ? 'selected' : '' }} value="rate">محبوبیت</option>
                    <option {{ isset($orderBy) && $orderBy == 'seen' ? 'selected' : '' }} value="seen">بازدید</option>
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
                <button onclick="excel()" class="btn btn-success">دریافت گزارش اکسل</button>
                <button onclick="filter()" class="btn btn-success">اعمال فیلتر</button>
            </div>
            
        </div>
        <table  id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عملیات</th>
                    <th>نام</th>
                    <th>تاریخ عضویت</th>
                    <th>تعداد پست الکترونیک دریافتی</th>
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
                                    <button data-toggle='tooltip' title="پست الکترونیک دریافتی" onclick="document.location.href = '{{ route('product.productGallery.index', ['product' => $item['id']]) }}'" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button>
                                    <button data-toggle='tooltip' title="حذف" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                </div>
                            </div>
                            
                        </td>
                        <td>{{ $item['mail'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td>{{ $item['received'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $links !!}
    @endif
    
</center>

<script src="{{ asset('admin-panel/js/pro_search.js') }}"></script>

    <script>

        function buildQuery() {
            
            let query = new URLSearchParams();

            let orderBy = $("#orderBy").val();
            let orderByType = $("#orderByType").val();
            let toCreatedAt = $("#toCreatedAt").val();
            let fromCreatedAt = $("#fromCreatedAt").val();
                
            if(toCreatedAt !== '')
                query.append('toCreatedAt', toCreatedAt);
                
            if(fromCreatedAt !== '')
                query.append('fromCreatedAt', fromCreatedAt);
                
            query.append('orderBy', orderBy);
            query.append('orderByType', orderByType);

            return query;
        }

        function filter() {
            document.location.href = '{{ route('mail.users') }}' + '?' + buildQuery().toString();
        }
        
        function excel() {
            window.open('{{ route('product.excel') }}' + '?' + buildQuery().toString(), '_blank');
        }

    </script>

@stop
