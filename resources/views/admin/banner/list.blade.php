@extends('admin.layouts.list')

@section('title')
مدیریت بنر های تبلیغاتی
@stop

@section('createNew')
'{{ route('banner.create') }}'
@stop

@section('items')
    @foreach($items as $item)
        <div style="min-height: 250px" class="column col-xs-12 col-lg-6 myContainer" id="item_{{ $item['id'] }}">
            <img class="my-form-img" src="{{$item['img']}}" alt="{{ $item['alt'] }}">
            <div class="overlay">
                <div class="opBox" id="opBox_{{ $item['id'] }}">
                    <button class="btn btn-primary" onclick="document.location.href = '{{ route('banner.edit', ['banner' => $item['id']]) }}'">مشاهده اطلاعات</button>
                    <button class="btn btn-danger" onclick="removeModal('item', {{$item['id']}}, '{{ route('banner.destroy', ['banner' => $item['id']]) }}')">حذف</button>
                </div>
            </div>
        </div>
    @endforeach
@stop
