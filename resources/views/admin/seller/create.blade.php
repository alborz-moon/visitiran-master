@extends('admin.layouts.create')

@section('title')
{{ isset($item) ? 'ویرایش فروشنده' : 'افزودن فروشنده' }}
@stop

@section('form')

    @if(isset($item))
        <div style="display: flex; flex-direction: row; gap: 20px; margin-right: 40px; margin-left: 40px;">
            <div>
                <p>تصویر فعلی</p>
                <img src="{{$item['logo']}}" alt="{{ $item['alt'] }}" style="width:150px;">
            </div>
        </div>
    @endif

    <form id="myForm" action="{{ isset($item) ? route('seller.update', ['seller' => $item['id']]) : route('seller.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="image_file">تصویر</label>
                <input type="file" name="image_file" id="image_file">
            </div>
            
            <div>
                <label for="alt">تگ alt</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="alt" id="alt" />
            </div>
            
            <div>
                <label for="name">نام</label>
                <input {{ isset($item) ? '' : 'required' }} value="{{ isset($item) ? $item['name'] : '' }}" type="text" name="name" id="name" />
            </div>
            
        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('seller.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop