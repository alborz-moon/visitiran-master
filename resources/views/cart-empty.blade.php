@extends('layouts.structure')
@section('content')
<div class="container">
        <main class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- start of nav-tabs -->
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link fs-6 fw-bold active" id="nav-1-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1"
                                    aria-selected="true">
                                    سبد خرید
                                </button>
                                <button class="nav-link fs-6 fw-bold" id="nav-2-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-2"
                                    aria-selected="false">
                                    لیست خرید بعدی
                                </button>
                            </div>
                        </nav>
                        <!-- end of nav-tabs -->
                        <!-- start of tab-content -->
                        <div class="tab-content" id="nav-tabContent">
                            <!-- start of tab-pane -->
                            <div class="tab-pane py-4 fade show active" id="nav-1" role="tabpanel"
                                aria-labelledby="nav-1-tab">
                                <div class="ui-box bg-white">
                                    <div class="ui-box-empty-content">
                                        <div class="ui-box-empty-content-icon">
                                            <img src="./theme-assets/images/theme/cart-empty.png" alt="">
                                        </div>
                                        <div class="ui-box-empty-content-message text-center">
                                            <div class="mb-3">سبد خرید شما خالی است!</div>
                                            <p class="text-secondary text-decoration-none fs-7 fw-bold">
                                                می‌توانید برای مشاهده محصولات بیشتر به صفحات زیر بروید
                                            </p>
                                            <div class="d-flex justify-content-center flex-wrap">
                                                <a href="#" class="link fs-7 fw-bold border-bottom-0 m-2">تخفیف‌ها و
                                                    پیشنهادها</a>
                                                <a href="#" class="link fs-7 fw-bold border-bottom-0 m-2">محصولات
                                                    پرفروش
                                                    روز</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of tab-pane -->
                            <!-- start of tab-pane -->
                            <div class="tab-pane py-4 fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab">
                                <div class="ui-box bg-white">
                                    <div class="ui-box-empty-content">
                                        <div class="ui-box-empty-content-icon">
                                            <img src="./theme-assets/images/theme/cart-empty-sfl.png" alt="">
                                        </div>
                                        <div class="ui-box-empty-content-message text-center">
                                            <div class="mb-3">لیست خرید بعدی شما خالی است!</div>
                                            <div class="col-8 mx-auto">
                                                <p class="text-secondary text-decoration-none fs-7 fw-bold">
                                                    شما می‌توانید محصولاتی که به سبد خرید خود افزوده‌اید و فعلا قصد خرید
                                                    آن‌ها را ندارید، در لیست خرید بعدی قرار داده و هر زمان مایل بودید
                                                    آن‌ها
                                                    را به سبد خرید اضافه کرده و خرید آن‌ها را تکمیل کنید.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of tab-pane -->
                        </div>
                        <!-- end of tab-content -->
                    </div>
                </div>
            </div>
        </main>
</div>
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
@stop