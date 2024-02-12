@extends('admin.layouts.list')

@section('title')
مدیریت بنر هدر
@stop

@section('createNew')
'{{ route('infobox.create') }}'
@stop

@section('items')
    @foreach($items as $item)
        <div style="min-height: 250px" class="column col-xs-12 col-lg-6 myContainer" id="item_{{ $item['id'] }}">
            <img src="{{$item['img_large']}}" alt="{{ $item['alt'] }}" style="width:100%; height: 100%">
            <div class="overlay">
                <div class="opBox" id="opBox_{{ $item['id'] }}">
                    <button class="btn btn-primary" onclick="document.location.href = '{{ route('infobox.edit', ['infobox' => $item['id']]) }}'">مشاهده اطلاعات</button>
                    <button class="btn btn-danger" onclick="removeModal('item', {{$item['id']}}, '{{ route('infobox.destroy', ['infobox' => $item['id']]) }}')">حذف</button>
                </div>
            </div>
        </div>
    @endforeach
@stop
