@extends('admin.layouts.structure')

@section('header')
    @parent
@stop

@section('content')

    <div class="col-md-12">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>
                        @yield('title')
                    </h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <div id="mainContainer" class="page-content" style="margin-top: 5%; margin: 50px; direction: rtl">
                    <div class="row">
                        <div id="addToolbarContainer" class="flex gap10">
                            @yield('backBtn')
                            @section('addBtn')
                                <button onclick="document.location.href = @yield('createNew')" class="btn btn-success">افزودن مورد جدید</button>
                            @show
                            @yield('preBtn', '')
                        </div>
                        <div class="col-xs-12">
                            @yield('items')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop