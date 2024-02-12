@extends('admin.layouts.create')
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
مدیریت تخفیف > {{ $item['name'] }}
@stop

@section('form')

    <form id="myForm" action="{{ route('product.update', ['product' => $item['id']])}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">
            
            <div>
                <label for="off">تخفیف</label>
                <input value="{{ isset($item) ? $item['off'] : '' }}" type="number" name="off" id="off" />
            </div>
            
            <div>
                <label for="off_type">نوع تخفیف</label>
                <select name="off_type" id="off_type">
                    <option {{ isset($item) && $item['off_type'] == 'percent' ? 'selected' : '' }} value="percent">درصدی</option>
                    <option {{ isset($item) && $item['off_type'] == 'value' ? 'selected' : '' }} value="value">مقداری</option>
                </select>
            </div>

            <div>
                <label>
                    تاریخ انقضا
                    <input type="button" style="border: none; width: 30px; height: 30px; background: url({{ asset('admin-panel/img/calendar-flat.png') }}) repeat 0 0; background-size: 100% 100%;" id="date_btn">
                    
                </label>
                <input value="{{ isset($item) ? $item['off_expiration'] : '' }}" name="off_expiration" type="text" id="date_input" readonly>
                <script>
                    Calendar.setup({
                        inputField: "date_input",
                        button: "date_btn",
                        ifFormat: "%Y/%m/%d",
                        dateType: "jalali"
                    });
                </script>
            </div>
            @error('off_expiration')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @if(isset($err))
                <p>{{ $err }}</p>
            @endif
        </div>


        <div class="flex center gap10">
            <span class="removeOffBtn btn btn-warning">حذف تخفیف</span>
            <span onclick="document.location.href = '{{ route('product.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>

    <script>

        $(document).ready(function() {

            $(".removeOffBtn").on('click', function() {
                removeOff();
            });

            function removeOff() {
                $.ajax({
                    type: 'post',
                    url: '{{ route('product.removeOff', ['product' => $item['id']]) }}',
                    success: function(res) {
                        if(res.status === "ok")
                            showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                    }
                });
            }

        });

        

    </script>
@stop