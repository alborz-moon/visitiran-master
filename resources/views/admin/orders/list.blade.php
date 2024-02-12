@extends('admin.layouts.list')

@section('title')
    گزارش گیری خرید
@stop

@section('items')

    <table id="table" data-toggle="table" data-search="true" data-show-columns="true" data-key-events="true"
        data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true"
        data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عملیات</th>
                <th>مبلغ پرداختی</th>
                <th>میزان تخفیف</th>
                <th>زمان خرید</th>
                <th>نام کاربر</th>
                <th>شماره همراه کاربر</th>
                <th>کد پیگیری</th>
                <th>کد پرداخت</th>
                <th>تعداد کالا</th>
                <th>وضعیت</th>
                <th>زمان انتخابی</th>
                <th>زمان تحویل</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span>
                        </button>
                    </td>
                    <td>{{ $item['total'] }}</td>
                    <td>{{ $item['off_amount'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['user']['name'] }}</td>
                    <td>{{ $item['user']['phone'] }}</td>
                    <td>{{ $item['tracking_code'] }}</td>
                    <td>{{ $item['items_count'] }}</td>
                    <td>{{ $item['status'] }}</td>
                    <td>{{ $item['time'] }}</td>
                    <td>{{ $item['delivery_at'] }}</td>
                </tr>

                <?php $i++; ?>
            @endforeach
        </tbody>
    </table>

@stop
