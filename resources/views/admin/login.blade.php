@extends('admin.layouts.structure')

@section('header')
    @parent
@stop


@section('content')
    <div class="col-md-12">
        <div class="sparkline8-list shadow-reset mg-tb-30">
            <div class="sparkline8-hd">
                <div class="main-sparkline8-hd">
                    <h1>ورود</h1>
                </div>
            </div>

            <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">

                <div id="mainContainer" class="page-content" style="margin-top: 5%; direction: rtl">

                    <div class="row">

                        <div class="col-xs-12">
                            <form method="post" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                
                                    <div class="flex flex-col center gap10" style="margin: 10px">
                                        
                                        <div>
                                            <label for="phone">نام کاربری</label>
                                            <input required name="phone" id="phone" />
                                        </div>
                                        
                                        <div>
                                            <label for="password">رمزعبور</label>
                                            <input type="password" required name="password" id="password" />
                                        </div>

                                        
                                        <div>
                                            <button type="submit" class="btn btn-success">ورود</button>
                                        </div>

                                        @if(isset($err))
                                            <p>{{ $err }}</p>
                                        @endif

                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop