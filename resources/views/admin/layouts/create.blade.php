@extends('admin.layouts.structure')

@section('header')
    @parent

    <style>

        #myForm > div:not(.editor) > div:not(.editor) {
            width: calc(100% - 20px);
        }

        #myForm > div:not(.editor) > div:not(.editor) {
            display: flex;
        }

        #myForm > div > div > label {
            width: 150px;
        }

        #myForm > div > div > textarea,
        #myForm > div > div > input,
        #myForm > div > div > select {
            width: calc(100% - 170px);
        }

    </style>

    @section('moreHeader')
    @show

@stop

@section('content')

    <div class="col-md-12">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>@yield('title')</h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <div id="mainContainer" class="page-content" style="margin-top: 5%; direction: rtl">

                    <div class="row">

                        <div class="col-xs-12" style="padding: 0">
                            {{-- @if(isset($category))
                                <div class="flex center">
                                    <img width="200px" src="{{ $category->img }}" />
                                </div>
                            @endif --}}
                            <div style="margin-top: 10px;">

                                <center id="errs">

                                    @if(isset($err))
                                        {{ $err }}
                                    @endif

                                    @if($errors->any())
                                        {!! implode('<br />', $errors->all(':message')) !!}
                                    @endif
                                </center>

                                @yield('form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop