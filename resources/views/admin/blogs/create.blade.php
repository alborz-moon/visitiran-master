@extends('admin.layouts.create')

@section('moreHeader')
    <script>
        var UploadURL = '{{ route('uploadImg') }}';
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{asset('admin-panel/js/ckeditor.js?v=2.2')}}"></script>
    
@stop

@section('title')
{{ isset($item) ? 'ویرایش بلاگ' . ' > ' . $item['header'] : 'افزودن بلاگ' }}
@stop

@section('form')

    @if(isset($item))
        <div class="flex center">
            <img width="200px" src="{{ $item['img'] }}" />
        </div>
    @endif

    <form id="myForm" action="{{ isset($item) ? route('blog.update', ['blog' => $item['id']]) : route('blog.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">
            
            <div>
                <label for="imgInp">تصویر اصلی (اختیاری)</label>
                <input type="file" name="img_file" id="imgInp">
            </div>
            
            <div>
                <label for="header">عنوان</label>
                <input required value="{{ isset($item) ? $item['header'] : old('header') }}" type="text" name="header" id="header" />
            </div>
            
            <div>
                <label for="slug">نامک(اختیاری)</label>
                <input value="{{ isset($item) ? $item['slug'] : old('slug') }}" placeholder="این فیلد اختیاری است" type="text" name="slug" id="slug" />
            </div>

            <div>
                <label for="digest">متن خلاصه</label>
                <textarea required name="digest" id="digest">{{ isset($item) ? $item['digest'] : '' }}</textarea>
            </div>

            <div>
                <label for="keywords">واژه های کلیدی(اختیاری)</label>
                <textarea name="keywords" id="keywords">{{ isset($item) ? $item['keywords'] : '' }}</textarea>
            </div>

            <div>
                <label for="article_tags">تگ ها سئو(اختیاری)</label>
                <textarea name="article_tags" id="article_tags">{{ isset($item) ? $item['article_tags'] : '' }}</textarea>
            </div>


            <div>
                <label for="tags">تگ موضوعی(اختیاری)</label>
                <textarea name="tags" id="tags">{{ isset($item) ? $item['tags'] : '' }}</textarea>
            </div>

            <div>
                <label for="alt">تگ alt(اختیاری)</label>
                <input value="{{ isset($item) ? $item['alt'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="alt" id="alt" />
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

                
            <div class="editor">
                <div id="toolbar-container"></div>
                @if(isset($item) && $item['description'] != null && $item['description'] != '')
                    <div id="description">{!!  $item['description'] !!}</div>
                @else
                    <div id="description"></div>
                @endif
            </div>
            <textarea id="desc" class="hidden" name="description"></textarea>
            
        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('blog.index') }}'" class="btn btn-danger">بازگشت</span>
            <span class="btn btn-primary" id="saveBtn">ذخیره</span>
        </div>

    </form>

    <script src="{{asset('admin-panel/js/initCKs.js?v=2.3')}}"></script>
    <script>
        $(document).ready(function () {
            initCK('{{ csrf_token() }}');
            $("#saveBtn").on('click', function() {
                $("#desc").val($("#description").html());
                $("#myForm").submit();
            });
        });
    </script>

@stop