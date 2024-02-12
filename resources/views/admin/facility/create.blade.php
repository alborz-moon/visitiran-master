@extends('admin.layouts.create')

@section('header')
    @parent
@stop

@section('title')
{{ isset($item) ? 'ویرایش امکانات' : 'افزودن به امکانات' }}
@stop

@section('form')
    
    <form id="myForm" action="{{ isset($item) ? route('facilities.update', ['facility' => $item->id]) : route('facilities.store')}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="label">عنوان</label>
                <input value="{{ isset($item) ? $item->label : '' }}" type="text" name="label" id="label" />
            </div>

            <div>
                <label for="visibility">وضعیت نمایش</label>
                <select name="visibility" id="visibility">
                    <option {{ isset($item) && !$item->visibility ? 'selected' : '' }} value="0">مخفی</option>
                    <option {{ isset($item) && $item->visibility ? 'selected' : '' }} value="1">نمایش</option>
                </select>
            </div>
        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('facilities.index') }}'" class="btn btn-danger">بازگشت</span>
            <input type="submit" value="ذخیره" class="btn green">
        </div>

    </form>
    
@stop