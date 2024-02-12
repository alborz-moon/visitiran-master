@extends('admin.layouts.list')

@section('title')
مدیریت فروشنده ها
@stop

@section('createNew')
'{{ route('seller.create') }}'
@stop

@section('items')
    @foreach($items as $item)
        <div class="col-xs-12 col-lg-3" id="item_{{ $item['id'] }}">
            <center>
                <h4 class="white-color font-size-17 font-wight-600">{{ $item['name'] }}</h4>
            </center>
            <img src="{{$item['logo']}}" alt="{{ $item['alt'] }}" style="width:100%; height: 100%">
            <div class="flex space-between">
                <button class="btn btn-primary" onclick="document.location.href = '{{ route('seller.edit', ['seller' => $item['id']]) }}'">مشاهده اطلاعات</button>
                <button class="btn btn-danger" onclick="removeModal('item', {{$item['id']}}, '{{ route('seller.destroy', ['seller' => $item['id']]) }}')">حذف</button>
            </div>
        </div>
    @endforeach
@stop
