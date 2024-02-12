@extends('admin.layouts.create')

@section('title')
{{ isset($item) ? 'ویرایش دسته' : 'افزودن دسته' }}
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

    <form id="myForm" action="{{ isset($item) ? route('category.update', ['category' => $item['id']]) : route('category.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="image_file">تصویر(اختیاری)</label>
                <input type="file" name="image_file" id="image_file">
            </div>

            <div>
                <label for="name">نام</label>
                <input {{ isset($item) ? '' : 'required' }} value="{{ isset($item) ? $item['name'] : '' }}" type="text" name="name" id="name" />
            </div>
            
            <div>
                <label for="alt">تگ alt</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="alt" id="alt" />
            </div>
            
            <div>
                <label for="keywords">کلمات کلیدی</label>
                <input value="{{ isset($item) ? $item['keywords'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="keywords" id="keywords" />
            </div>
            
            <div>
                <label for="tags">تگ ها</label>
                <input value="{{ isset($item) ? $item['tags'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="tags" id="tags" />
            </div>
            
            <div>
                <label for="digest">خلاصه توضیح</label>
                <textarea type="text" placeholder="این فیلد اختیاری است" name="digest" id="digest">{{ isset($item) ? $item['digest'] : '' }}</textarea>
            </div>

            <div>
                <label for="priority">اولویت</label>
                <input value="{{ isset($item) ? $item['priority'] : '' }}" type="number" required name="priority" id="priority" />
            </div>

            <div>
                <label for="visibility">وضعیت نمایش</label>
                <select name="visibility" id="visibility">
                    <option {{ isset($item) && !$item['visibility'] ? 'selected' : '' }} value="0">مخفی</option>
                    <option {{ isset($item) && $item['visibility'] ? 'selected' : '' }} value="1">نمایش</option>
                </select>
            </div>
            
            <div>
                <label for="show_in_first_page">نمایش در دسته های برتر</label>
                <select name="show_in_first_page" id="show_in_first_page">
                    <option {{ isset($item) && !$item['show_in_first_page'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['show_in_first_page'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>
            
            <div>
                <label for="show_items_in_first_page">نمایش محصولات این دسته در صفحه نخست</label>
                <select name="show_items_in_first_page" id="show_items_in_first_page">
                    <option {{ isset($item) && !$item['show_items_in_first_page'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['show_items_in_first_page'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>
            
            <div>
                <label for="parent_id">دسته بالادستی</label>
                <select name="parent_id" id="parent_id">
                    <option {{ isset($item) && $item['parent_id'] == null ? 'selected' : '' }} value=''>ندارد</option>
                    @foreach($categories as $cat)
                        <option {{ isset($item) && $item['parent_id'] == $cat['id'] ? 'selected' : '' }} value="{{$cat['id']}}">{{$cat['name']}}</option>
                    @endforeach
                </select>
            </div>

        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('category.index') }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop