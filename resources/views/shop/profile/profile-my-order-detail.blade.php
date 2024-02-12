
@extends('layouts.structure')
@section('content')
        <main class="page-content">
            <div class="container">
                <div class="row mb-5">
                        @include('shop.profile.layouts.profile_menu')     
                    <div class="col-xl-9 col-lg-8 col-md-7">
                        <div class="ui-box bg-white">
                            <div class="ui-box-title flex-wrap">
                                <a href="{{ route('profile.my-orders') }}" class="link border-bottom-0 fs-3 me-2"><i
                                        class="ri-arrow-right-fill"></i></a>
                                <span class="me-3">جزئیات سفارش</span>
                                <span class="fs-7 fa-num">تاریخ</span>
                                <i class="ri-record-circle-fill fs-7 text-muted mx-2"></i>
                                <span class="font-en">شماره سفارش</span>
                            </div>
                            {{-- <div class="ui-box-content">
                                <!-- start of user-order-items -->
                                <div class="user-order-items">
                                    <!-- start of user-order-item -->
                                    <div class="user-order-item">
                                        <div class="user-order-item-header">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
                                                        <span class="user-order-meta fa-num"><span
                                                                class="text-muted me-1">گیرنده:</span> نام و نام خانوادگی گیرنده</span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
                                                        <span class="user-order-meta fa-num">تاریخ</span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
                                                        <span class="user-order-meta">شماره سفارش</span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
                                                        <span class="user-order-meta text-danger">سفارش لغو شده</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="text-muted fw-bold">مبلغ کل:</span>
                                                <span class="fw-bold fa-num">
                                                    <span>تومان</span></span>
                                            </div>
                                        </div>
                                        <div class="user-order-item-content">
                                            <div class="my-3">
                                                <span class="text-dark fa-num">مرسوله 1 از 1</span>
                                            </div>
                                            <div class="cart-items">
                                                اینجا باید متصل بشه به Api
                                                <div class="cart-item">
                                                    <div class="cart-item--thumbnail">
                                                        <a href="#">
                                                            <img src="./theme-assets/images/carts/01.jpg" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="cart-item--detail">
                                                        <h2 class="cart-item--title mb-2"><a href="#">هدفون بی سیم
                                                                سامسونگ مدل
                                                                Galaxy Buds
                                                                Live</a></h2>
                                                        <div class="cart-item--variant mb-2">
                                                            <span class="color"
                                                                style="background-color: #fad7c2;"></span>
                                                            <span class="ms-1">طلایی</span>
                                                        </div>
                                                        <div class="cart-item--data mb-4">
                                                            <ul>
                                                                <li><i
                                                                        class="ri-shield-check-fill text-secondary"></i><span>گارانتی
                                                                        اصالت و
                                                                        سلامت فیزیکی
                                                                        کالا</span></li>
                                                                <li><i class="ri-store-3-fill text-secondary"></i><span>اسم
                                                                        فروشگاه</span>
                                                                </li>
                                                                <li>
                                                                    <i
                                                                        class="ri-checkbox-multiple-fill text-primary"></i><span>موجود
                                                                        در
                                                                        انبار</span>
                                                                    <span class="text-secondary mx-2">|</span>
                                                                    <i class="ri-truck-fill text-danger"></i><span>ارسال
                                                                        (نحوه
                                                                        ارسال)</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="cart-item--price--actions justify-content-end">
                                                            <div
                                                                class="cart-item--price fa-num d-flex align-items-center flex-wrap">
                                                                <div class="cart-item--price-now me-3">
                                                                    <span>2,110,000</span>
                                                                    <span class="currency">تومان</span>
                                                                </div>
                                                                <div class="cart-item--discount">
                                                                    <span>تخفیف</span>
                                                                    <del>10,000</del>
                                                                    <span class="currency">تومان</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of user-order-item -->
                                </div>
                                <!-- end of user-order-items -->
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
@stop