@extends('admin.layouts.create')

@section('moreHeader')
    <script>
        var UploadURL = '{{ route('uploadImg') }}';
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/decoupled-document/ckeditor.js"></script>
    <script src="{{asset('admin-panel/js/ckeditor.js?v=2.2')}}"></script>
    <style>
        label {
            width: 300px !important;
        }
    </style>
@stop

@section('title')
{{ 'پیکربندی' }}
@stop

@section('form')
    <form id="myForm" action="{{ route('config.update')}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="sell_list_period">بازه مربوط به پرفروش ترین ها</label>
                <input value="{{ $item->sell_list_period }}" type="number" required name="sell_list_period" id="sell_list_period" />
            </div>
            
            <div>
                <label for="seen_list_period">بازه مربوط به پربازدید ها</label>
                <input value="{{ $item->seen_list_period }}" type="number" required name="seen_list_period" id="seen_list_period" />
            </div>
            
            <div>
                <label for="home_banner_limit">محدودیت بنرهای صفحه نخست</label>
                <input value="{{ $item->home_banner_limit }}" type="number" required name="home_banner_limit" id="home_banner_limit" />
            </div>
            
            <div>
                <label for="list_banner_limit">محدودیت بنرهای صفحه لیست</label>
                <input value="{{ $item->list_banner_limit }}" type="number" required name="list_banner_limit" id="list_banner_limit" />
            </div>

            <div>
                <label for="detail_banner_limit">محدودیت بنرهای صفحه محصول</label>
                <input value="{{ $item->detail_banner_limit }}" type="number" required name="detail_banner_limit" id="detail_banner_limit" />
            </div>
            
            <div>
                <label for="critical_point">نقطه بحرانی تعداد محصول</label>
                <input value="{{ $item->critical_point }}" type="number" required name="critical_point" id="critical_point" />
            </div>
            
            <div>
                <label for="can_pay_cash">امکان پرداخت حضوری</label>
                <select name="can_pay_cash" id="can_pay_cash">
                    <option {{ !$item->can_pay_cash ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ $item->can_pay_cash ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>
        </div>

        <div class="editor">
            <div id="toolbar-container"></div>
            @if($item->desc_default != null && $item->desc_default != '')
                <div id="description">{!!  $item->desc_default !!}</div>
            @else
                <div id="description"></div>
            @endif
        </div>
        <textarea id="desc_default" class="hidden" name="desc_default"></textarea>
        <div class="flex center gap10 margin20">
            <span class="btn btn-primary" id="saveBtn">ذخیره</span>
        </div>

    </form>
    
    <script src="{{asset('admin-panel/js/initCKs.js?v=2.3')}}"></script>
    <script>
        $(document).ready(function () {
            initCK('{{ csrf_token() }}');
            $("#saveBtn").on('click', function() {
                $("#desc_default").val($("#description").html());
                $("#myForm").submit();
            });
        });
    </script>
@stop