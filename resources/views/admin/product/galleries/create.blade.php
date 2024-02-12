@extends('admin.layouts.create')

@section('title')
افزودن تصویر > {{  $productName }}
@stop

@section('form')

    <form id="myForm" action="{{route('product.productGallery.store', ['product' => $productId])}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">
            
            <input {{ isset($item) ? '' : 'required' }} type="file" name="img_file" id="imgInp">

            <div>
                <label for="alt">تگ alt</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="alt" id="alt" />
            </div>
            
            <div>
                <label for="priority">اولویت</label>
                <input required value="{{ isset($item) ? $item['priority'] : '' }}" type="number" name="priority" id="priority" />
            </div>

        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('product.productGallery.index', ['product' => $productId]) }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop