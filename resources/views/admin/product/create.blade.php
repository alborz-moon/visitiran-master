@extends('admin.layouts.create')


@section('header')
    @parent
    <script>
        var UploadURL = '{{ route('uploadImg') }}';
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{ asset('admin-panel/js/ckeditor.js?v=2.2') }}"></script>
@stop

@section('title')
    {{ isset($item) ? 'ویرایش محصول' . ' > ' . $item['name'] : 'افزودن محصول' }}
@stop

@section('form')

    @if (isset($item))
        <div class="flex center">
            <img width="200px" src="{{ $item['img'] }}" />
        </div>
    @endif

    <form id="myForm"
        action="{{ isset($item) ? route('product.update', ['product' => $item['id']]) : route('product.store') }}"
        method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="imgInp">تصویر اصلی (اختیاری)</label>
                <input type="file" name="img_file" id="imgInp">
            </div>


            <div>
                <label for="name">نام</label>
                <input required value="{{ isset($item) ? $item['name'] : '' }}" type="text" name="name"
                    id="name" />
            </div>


            <div>
                <label for="slug">slug(اختیاری)</label>
                <input value="{{ isset($item) ? $item['slug'] : '' }}" placeholder="این فیلد اختیاری است" type="text"
                    name="slug" id="slug" />
            </div>

            <div>
                <label for="desc">توضیح محصول(اختیاری)</label>
                <textarea name="description" placeholder="این فیلد اختیاری است" id="desc">{{ isset($item) ? $item['description'] : '' }}</textarea>
            </div>

            <div>
                <label for="digest">متن خلاصه(اختیاری)</label>
                <textarea placeholder="این فیلد اختیاری است" name="digest" id="digest">{{ isset($item) ? $item['digest'] : '' }}</textarea>
            </div>

            <div>
                <label for="keywords">واژه های کلیدی(اختیاری)</label>
                <textarea placeholder="این فیلد اختیاری است" name="keywords" id="keywords">{{ isset($item) ? $item['keywords'] : '' }}</textarea>
            </div>

            <div>
                <label for="tags">تگ ها(اختیاری)</label>
                <textarea placeholder="این فیلد اختیاری است" name="tags" id="tags">{{ isset($item) ? $item['tags'] : '' }}</textarea>
            </div>

            <div>
                <label for="alt">تگ alt(اختیاری)</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است"
                    name="alt" id="alt" />
            </div>

            <div>
                <label for="price">قیمت</label>
                <input required value="{{ isset($item) ? $item['price'] : '' }}" type="number" name="price"
                    id="price" />
            </div>

            <div>
                <label for="guarantee">گارانتی(اختیاری)</label>
                <input value="{{ isset($item) ? $item['guarantee'] : '' }}" placeholder="این فیلد اختیاری است"
                    type="number" name="guarantee" id="guarantee" />
            </div>

            <div>
                <label for="category_id">دسته موردنظر</label>
                <select name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option {{ isset($item) && $item['category_id'] == $category['id'] ? 'selected' : '' }}
                            value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="brand_id">برند موردنظر</label>
                <select name="brand_id" id="brand_id">
                    @foreach ($brands as $brand)
                        <option {{ isset($item) && $item['brand_id'] == $brand['id'] ? 'selected' : '' }}
                            value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label for="seller_id">فروشنده(اختیاری)</label>
                <select name="seller_id" id="seller_id">
                    <option value="-1">نامشخص</option>
                    @foreach ($sellers as $seller)
                        <option {{ isset($item) && $item['seller_id'] == $seller['id'] ? 'selected' : '' }}
                            value="{{ $seller['id'] }}">{{ $seller['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="priority">اولویت</label>
                <input value="{{ isset($item) ? $item['priority'] : '' }}" type="number" required name="priority"
                    id="priority" />
            </div>

            <div>
                <label for="visibility">وضعیت نمایش</label>
                <select name="visibility" id="visibility">
                    <option {{ isset($item) && !$item['visibility'] ? 'selected' : '' }} value="0">مخفی</option>
                    <option {{ isset($item) && $item['visibility'] ? 'selected' : '' }} value="1">نمایش</option>
                </select>
            </div>

            <div>
                <label for="is_in_top_list">آیا جز محصولات برتر است؟</label>
                <select name="is_in_top_list" id="is_in_top_list">
                    <option {{ isset($item) && !$item['is_in_top_list'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['is_in_top_list'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>

            <p style="margin-top: 20px">نقد و بررسی(اختیاری)</p>
            <div class="editor">
                <div id="toolbar-container"></div>
                @if (isset($item) && $item['introduce'] != null && $item['introduce'] != '')
                    <div id="description">{!! $item['introduce'] !!}</div>
                @else
                    <div id="description"></div>
                @endif
            </div>

            <input type="hidden" id="introduce" name="introduce" />
        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('product.index') }}'" class="btn btn-danger">بازگشت</span>
            <span type="submit" class="btn btn-success" id="saveBtn">ذخیره</span>
        </div>

    </form>


    <script src="{{ asset('admin-panel/js/initCKs.js?v=2.3') }}"></script>
    <script>
        $(document).ready(function() {
            initCK('{{ csrf_token() }}');
            $("#saveBtn").on('click', function() {

                if (!'{{ isset($item) }}') {
                    $("#errs").empty();
                    let hasErr = false;

                    $("#myForm input").map((index, elem) => {
                        if (elem.required && (elem.value === undefined || elem.value === '')) {
                            labels = $("#myForm label");
                            for (var i = 0; i < labels.length; i++) {
                                if (labels[i].htmlFor == elem.id) {
                                    $("#errs").append("لطفا " + labels[i].innerText +
                                        " را وارد کنید").append("<br />");
                                    break;
                                }
                            }
                            hasErr = true;
                            elem.classList.add('err-input');
                        }
                    });
                }

                let err = $("#errs").text().replace(/\s/g, '');

                if (err !== undefined && err !== null && err !== '') {

                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#errs").offset().top
                    }, 500);

                    return;
                }

                $("#introduce").val($("#description").html());
                $("#myForm").submit();
            });
        });
    </script>
@stop
