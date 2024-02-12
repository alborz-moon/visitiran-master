@extends('admin.layouts.list')

@section('title')
مدیریت ویژگی ها > {{ $categoryName }}
@stop

@section('createNew')
'{{ route('category.features.create', ['category' => $categoryId]) }}'
@stop

@section('backBtn')
<button onclick="document.location.href = '{{ route('category.index') }}'" class="btn btn-danger">بازگشت</button>
@stop

@section('items')

    <table id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>نام</th>
                <th>آیا این ویژگی کلیدی است؟</th>
                <th>آیا در قیمت تاثیرگذار است؟</th>
                <th>آیا در موجودی تاثیرگذار است؟</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($items as $item)
        
                <tr id="item_{{ $item['id'] }}">
                    <td>{{ $i }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['show_in_top'] ? 'بله' : 'خیر' }}</td>
                    <td>{{ $item['effect_on_price'] ? 'بله' : 'خیر' }}</td>
                    <td>{{ $item['effect_on_available_count'] ? 'بله' : 'خیر' }}</td>
                    <td>
                        <button onclick="document.location.href = '{{ route('features.edit', ['feature' => $item['id']]) }}'" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button onclick="removeModal('item', {{$item['id']}}, '{{ route('features.destroy', ['feature' => $item['id']]) }}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
                
                <?php $i++; ?>
            @endforeach

        </tbody>
    </table>
@stop
