@extends('admin.layouts.create')

@section('title')
{{ isset($item) ? 'ویرایش بنر اطلاعات' : 'افزودن بنر اطلاعات' }}
@stop

@section('form')

    @if(isset($item))
        <div style="display: flex; flex-direction: row; gap: 20px; margin-right: 40px; margin-left: 40px;">
            <div>
                <p>تصویر فعلی سایز بزرگ</p>
                <img src="{{$item['img_large']}}" alt="{{ $item['alt'] }}" style="width:150px;">
            </div>
            
            <div>
                @if($item['img_mid'] != null)
                    <p>تصویر فعلی سایز متوسط</p>
                    <img src="{{$item['img_mid']}}" alt="{{ $item['alt'] }}" style="width:150px">
                @endif
            </div>
            
            <div>
                @if($item['img_small'] != null)
                    <p>تصویر فعلی سایز کوچک</p>
                    <img src="{{$item['img_small']}}" alt="{{ $item['alt'] }}" style="width:150px">
                @endif
            </div>    
        </div>
    @endif

    <form id="myForm" action="{{ isset($item) ? route('infobox.update', ['infobox' => $item['id']]) : route('infobox.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="image_file_large">تصویر سایز بزرگ</label>
                <input {{ isset($item) ? '' : 'required' }} type="file" name="image_file_large" id="image_file_large">
            </div>
            
            <div>
                <label for="image_file_mid">تصویر سایز متوسط</label>
                <input type="file" name="image_file_mid" id="image_file_mid">
            </div>
            
            <div>
                <label for="image_file_small">تصویر سایز کوچک</label>
                <input type="file" name="image_file_small" id="image_file_small">
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
                <label for="collapse_from">از چه جهتی جمع شود؟</label>
                <select name="collapse_from" id="collapse_from">
                    <option {{ isset($item) && $item['collapse_from'] == 'right' ? 'selected' : '' }} value="right">راست</option>
                    <option {{ isset($item) && $item['collapse_from'] == 'left' ? 'selected' : '' }} value="left">چپ</option>
                    <option {{ isset($item) && $item['collapse_from'] == 'center' ? 'selected' : '' }} value="center">مرکز</option>
                </select>
            </div>
        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('infobox.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop