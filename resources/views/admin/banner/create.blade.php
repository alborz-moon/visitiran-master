@extends('admin.layouts.create')

@section('title')
{{ isset($item) ? 'ویرایش بنر تبلیغاتی' : 'افزودن بنر تبلیغاتی' }}
@stop

@section('form')

    @if(isset($item))
        <div style="display: flex; flex-direction: row; gap: 20px; margin-right: 40px; margin-left: 40px;">
            <div>
                <p>تصویر فعلی</p>
                <img src="{{$item['img']}}" alt="{{ $item['alt'] }}" style="width:150px;">
            </div>
        </div>
    @endif

    <form id="myForm" action="{{ isset($item) ? route('banner.update', ['banner' => $item['id']]) : route('banner.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="image_file">تصویر</label>
                <input {{ isset($item) ? '' : 'required' }} type="file" name="image_file" id="image_file">
            </div>
            
            <div>
                <label for="alt">تگ alt</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="alt" id="alt" />
            </div>
                
            <div>
                <label for="href">لینک</label>
                <input value="{{ isset($item) ? $item['href'] : '' }}" type="text" name="href" id="href"/>
            </div>

            <div>
                <label for="section">بخش مربوطه</label>
                <select name="section" id="section">
                    <option {{ isset($item) && $item['section'] == 'home' ? 'selected' : '' }} value="home">صفحه اصلی</option>
                    <option {{ isset($item) && $item['section'] == 'list' ? 'selected' : '' }} value="list">صفحات list</option>
                    <option {{ isset($item) && $item['section'] == 'detail' ? 'selected' : '' }} value="datail">صفحات detail</option>
                </select>
            </div>
        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('banner.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop