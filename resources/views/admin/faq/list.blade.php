@extends('admin.layouts.list')

@section('title')
مدیریت سوالات متداول
@stop

@section('createNew')
'{{ route('faq.create') }}'
@stop

@section('items')
    
    <table id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>سوال</th>
                <th>وضعیت نمایش</th>
                <th>اولویت</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($items as $item)
                
                <tr id="item_{{ $item->id }}">
                    <td>{{ $i }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->visibility ? 'نمایش' : 'عدم نمایش' }}</td>
                    <td>{{ $item->priority }}</td>
                    <td>
                        <button onclick="document.location.href = '{{ route('faq.edit', ['faq' => $item->id]) }}'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button onclick="removeModal('item', {{$item['id']}}, '{{ route('faq.destroy', ['faq' => $item['id']]) }}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>

                <?php $i++; ?>
            @endforeach
        </tbody>
    </table>
    
@stop
