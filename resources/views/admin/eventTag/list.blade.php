@extends('admin.layouts.list')

@section('title')
مدیریت تگ ها
@stop

@section('createNew')
'{{ route('eventTags.create') }}'
@stop

@section('items')
     
    <table id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>عنوان</th>
                <th>وضعیت نمایش</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($items as $item)
                
                <tr id="item_{{ $item['id'] }}">
                    <td>{{ $i }}</td>
                    <td>{{ $item['label'] }}</td>
                    <td>{{ $item['visibility'] ? 'نمایش' : 'عدم نمایش' }}</td>
                    <td>
                        <button onclick="document.location.href = '{{ route('eventTags.edit', ['eventTag' => $item['id']]) }}'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></button>
                        <button onclick="removeModal('item', {{$item['id']}}, '{{ route('eventTags.destroy', ['eventTag' => $item['id']]) }}')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>

                <?php $i++; ?>
            @endforeach
        </tbody>
    </table>
    
@stop
