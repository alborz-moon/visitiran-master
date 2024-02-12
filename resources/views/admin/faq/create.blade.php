@extends('admin.layouts.create')

@section('header')
    @parent
    <script>
        var UploadURL = '{{ route('uploadImg') }}';
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{asset('admin-panel/js/ckeditor.js?v=2.2')}}"></script>
@stop

@section('title')
{{ isset($item) ? 'ویرایش سوالات متداول' : 'افزودن سوال متداول' }}
@stop

@section('form')
    <form id="myForm" action="{{ isset($item) ? route('faq.update', ['faq' => $item->id]) : route('faq.store')}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="title">متن سوال</label>
                <input value="{{ isset($item) ? $item->title : '' }}" type="text" name="title" id="title" />
            </div>

            <div>
                <label for="priority">اولویت</label>
                <input value="{{ isset($item) ? $item->priority : '' }}" type="number" required name="priority" id="priority" />
            </div>
                
            @if(isset($item))
                <div>
                    <label for="visibility">وضعیت نمایش</label>
                    <select name="visibility" id="visibility">
                        <option {{ !$item->visibility ? 'selected' : '' }} value="0">مخفی</option>
                        <option {{ $item->visibility ? 'selected' : '' }} value="1">نمایش</option>
                    </select>
                </div>
            @endif
        </div>

        <div class="editor">
            <div id="toolbar-container"></div>
            @if(isset($item))
                <div id="description">{!!  $item->description !!}</div>
            @else
                <div id="description"></div>
            @endif
            
        </div>
        <textarea id="desc" class="hidden" name="description"></textarea>
        <div class="flex center gap10 margin20">
            <span onclick="document.location.href = '{{ route('faq.index') }}'" class="btn btn-danger">بازگشت</span>
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