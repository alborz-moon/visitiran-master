@extends('admin.layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    <div class="col-md-12">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd flex space-between">
                    <h1>
                        <span>مدیریت دسته ها</span>
                        @if(!empty($name))
                            <span> / </span>
                        @endif
                        <span>{{ $name }}</span>
                    </h1>
                    @if(!empty($name))
                        <button onclick="document.location.href = '{{ $isHead ? route('category.index')  : route('category.sub', ['category' => $parent_id])}}'" class="btn btn-danger">بازگشت</button>
                    @endif
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <div id="mainContainer" class="page-content" style="margin-top: 5%; margin: 50px; direction: rtl">

                    <div class="row">
                        <div class="flex flex-start gap50">

                            <div>
                                <button onclick="document.location.href = '{{ route('category.create') }}'" class="btn btn-success">افزودن مورد جدید</button>
                                <button onclick="$('#addBatchModal').removeClass('hidden')" class="btn btn-success">افزودن دسته ای</button>
                            </div>
                            
                            <div>
                                <label for="presentType">نوع نمایش</label>
                                <select id="presentType">
                                    <option value="card">کارتی</option>
                                    <option value="table">جدولی</option>
                                </select>
                            </div>
                            
                        </div>

                        <div class="flex flex-start gap10 margin20">
                        </div>

                        <div class="col-xs-12">
                            @if(isset($errors) && $errors != null && count($errors) > 0)
                                @foreach ($errors as $error)
                                    <div>{{$error}}</div>
                                @endforeach
                            @else
                                
                                <center><p>تعداد کل: {{ count($categories) }}</p></center>

                                <div id="card-view">
                                    @foreach($categories as $category)
                                        <div class="col-xs-12 col-lg-3" id="item_{{ $category['id'] }}">
                                            <center>
                                                <h5 class="white-color font-size-17 font-wight-600">{{ $category['name'] }}</h5>
                                            </center>
                                            <img src="{{$category['img']}}" alt="{{ $category['alt'] }}" class="my-form-img">
                                            <div class="flex space-between flex-wrap gap10 padding-6-6">
                                                <button class="btn btn-primary padding-6-6" onclick="document.location.href = '{{ route('category.edit', ['category' => $category['id']]) }}'">مشاهده اطلاعات</button>
                                                <button class="btn btn-danger padding-6-6" onclick="removeModal('item', {{$category['id']}}, '{{ route('category.destroy', ['category' => $category['id']]) }}')">حذف</button>
                                                @if($category['has_sub'])
                                                    <button onclick="document.location.href = '{{ route('category.sub', ['category' => $category['id']]) }}'" class="btn btn-info padding-6-6">مشاهده زیر دسته ها</button>
                                                @else
                                                    <button onclick="document.location.href = '{{ route('category.features.index', ['category' => $category['id']]) }}'" class="btn btn-info padding-6-6">ویژگی ها</button>
                                                    <button onclick="document.location.href = '{{ route('product.index', ['category' => $category['id']]) }}'" class="btn btn-warning padding-6-6">محصولات</button>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                                <div id="table-view" class="hidden">
                                    <table  id="table" data-toggle="table" data-search="true" data-show-columns="true"  data-key-events="true" data-show-toggle="true" data-resizable="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <th>نام</th>
                                            <th>تعداد زیردسته</th>
                                            <th>تعداد ویژگی</th>
                                            <th>تعداد محصول</th>
                                            <th>عملیات</th>
                                        </thead>
                                        @foreach($categories as $category)
                                            <tr id="item_{{ $category['id'] }}">
                                                <td>{{ $category['name'] }}</td>
                                                @if($category['has_sub'])
                                                    <td>{{ $category['childs_count'] }}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                @else
                                                    <td>0</td>
                                                    <td>{{ $category['features_count'] }}</td>
                                                    <td>{{ $category['products_count'] }}</td>
                                                @endif
                                                <td>
                                                    <div class="flex flex-wrap gap10">
                                                        <button class="btn btn-primary padding-6-6" onclick="document.location.href = '{{ route('category.edit', ['category' => $category['id']]) }}'">مشاهده اطلاعات</button>
                                                        <button class="btn btn-danger padding-6-6" onclick="removeModal('item', {{$category['id']}}, '{{ route('category.destroy', ['category' => $category['id']]) }}')">حذف</button>
                                                        @if($category['has_sub'])
                                                            <button onclick="document.location.href = '{{ route('category.sub', ['category' => $category['id']]) }}'" class="btn btn-info padding-6-6">مشاهده زیر دسته ها</button>
                                                        @else
                                                            <button onclick="document.location.href = '{{ route('category.features.index', ['category' => $category['id']]) }}'" class="btn btn-info padding-6-6">ویژگی ها</button>
                                                            <button onclick="document.location.href = '{{ route('product.index', ['category' => $category['id']]) }}'" class="btn btn-warning padding-6-6">محصولات</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="addBatchModal" class="modal hidden">
        <div class="modal-content" style="width: 70% !important">
            <input type="hidden" value="" id="slideId" name="id">
            <input type="hidden" value="delete" name="kind">
            
            <form method="post" action="{{ route('category.upload') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <center style="margin: 10px">
                    <h3>لطفا فایل اکسل را مطابق فایل نمونه بارگزاری نمایید.</h3>
                    <div style="margin: 10px">
                        <a href="{{ asset('categories.xlsx') }}" target="_blank" download>دانلود فایل نمونه</a>
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


    <script>

        $(document).on('ready', function() {
            $("#presentType").on('change', function() {
                if($(this).val() === "table") {
                    $("#table-view").removeClass('hidden');
                    $("#card-view").addClass('hidden');
                }
                else {
                    $("#table-view").addClass('hidden');
                    $("#card-view").removeClass('hidden');
                }
            });
        });

    </script>
@stop