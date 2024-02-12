@extends('admin.layouts.list')

@section('title')
مدیریت بلاگ ها
@stop

@section('createNew')
'{{ route('blog.create') }}'
@stop

@section('backBtn')
    <button onclick="$('#addBatchModal').removeClass('hidden')" class="btn btn-success">افزودن دسته ای</button>
@stop

@section('items')

<center style="margin-top: 20px">
    
    @if(isset($errors) && $errors != null && count($errors) > 0)
        @foreach ($errors as $error)
            <div>{{$error}}</div>
        @endforeach
    @else
        @foreach($items as $item)
            <div style="min-height: 250px" class="col-xs-12 col-lg-3" id="item_{{ $item['id'] }}">
                <h4 class="white-color font-size-17 font-wight-600">{{ $item['header'] }}</h4>
                <img class="my-form-img" src="{{$item['img']}}" alt="{{ $item['alt'] }}">
                <div>
                    <div class="opBox" id="opBox_{{ $item['id'] }}">
                        <button class="btn btn-primary" onclick="document.location.href = '{{ route('blog.edit', ['blog' => $item['id']]) }}'">مشاهده اطلاعات</button>
                        <button class="btn btn-danger" onclick="removeModal('item', {{$item['id']}}, '{{ route('blog.destroy', ['blog' => $item['id']]) }}')">حذف</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    
</center>

    <div id="addBatchModal" class="modal hidden">
        <div class="modal-content" style="width: 70% !important">
            <input type="hidden" value="" id="slideId" name="id">
            <input type="hidden" value="delete" name="kind">
            
            <form method="post" action="{{ route('blog.addBatch') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <center style="margin: 10px">
                    <h3>لطفا فایل اکسل را مطابق فایل نمونه بارگزاری نمایید.</h3>
                    <div style="margin: 10px">
                        <a href="{{ asset('blogs.xls') }}" target="_blank" download>دانلود فایل نمونه</a>
                    </div>
                    <input type="file" name="file" />
                </center>
                <div class="flex center gap10">
                    <input type="submit" value="افزودن" class="btn green"  style="margin-right: 5px; margin-bottom: 3%">
                    <input type="button" value="انصراف" class="btn green"  style="margin-bottom: 3%; margin-left: 5px;" onclick="$('#addBatchModal').addClass('hidden')">
                </div>
            </form>
        </div>
    </div>

@stop
