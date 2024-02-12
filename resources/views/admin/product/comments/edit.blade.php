@extends('admin.layouts.create')

@section('title')
{{ 'ویرایش نظر'}}
@stop

@section('form')


    <center>
        <p>کاربر مربوطه: {{ $item['user'] }}</p>
        <p>تاریخ ایجاد: {{ $item['created_at'] }}</p>
        <p>تاریخ تایید: {{ $item['status'] ? $item['confirmed_at'] : 'هنوز تایید نشده است' }}</p>
    </center>
    <form id="myForm" action="{{ $updateUrl }}" method="post">
        @csrf

        <div class="flex flex-col center gap10" style="margin: 10px">
                
            <div>
                <label for="rate">امتیاز</label>
                <input value="{{ $item['rate'] == null ? 0 : $item['rate'] }}" type="number" name="rate" id="rate" />
            </div>

            <div>
                <label for="msg">متن پیام</label>
                <textarea type="text" name="msg" id="msg">{{ $item['msg'] }}</textarea>
            </div>

            <div style="display: block !important">
                <label for="positive">نقاط قوت</label>
                <?php $i = 0; ?>
                @foreach ($item['positive'] as $itr)
                    <input type="text" value="{{ $itr }}" name="positive[]" />
                    <?php $i++; ?>
                @endforeach
            </div>


            <div style="display: block !important">
                <label for="negative">نقاط ضعف</label>
                <?php $i = 0; ?>
                @foreach ($item['negative'] as $itr)
                    <input type="text" value="{{ $itr }}" name="negative[]" />
                    <?php $i++; ?>
                @endforeach
            </div>

            <div>
                <label for="status">وضعیت</label>
                <select name="status" id="status">
                    <option {{ !$item['status'] ? 'selected' : '' }} value="0">تایید نشده</option>
                    <option {{ $item['status'] ? 'selected' : '' }} value="1">تایید شده</option>
                </select>
            </div>
        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ $backUrl }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop