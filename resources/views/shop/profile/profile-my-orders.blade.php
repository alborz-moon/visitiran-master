@extends('layouts.structure')
@section('content')
	<main class="page-content">
		<div class="container">
			<div class="row mb-5">
				@include('shop.profile.layouts.profile_menu')
				<div class="col-xl-9 col-lg-8 col-md-7">
					<div class="ui-box bg-white">
						<div class="ui-box-title">تاریخچه سفارشات</div>
						<div class="ui-box-content">
							<!-- start of order-tabs -->
							<div id="nothingToShow" class="hidden">

								<div style=" height: 180px">
									<img class=" h-100 " src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
								</div>

								<div> موردی برای نمایش موجود نیست</div>

							</div>
							<div class="order-tabs hidden">
								<ul class="nav nav-tabs fa-num" id="myTab" role="tablist">

									<li class="nav-item" role="presentation">
										<button class="nav-link d-inline-flex align-items-center active" id="wait-for-payment-tab" data-bs-toggle="tab"
											data-bs-target="#wait-for-payment" type="button" role="tab" aria-controls="wait-for-payment"
											aria-selected="true">
											پرداخت شده <span class="badge rounded-pill bg-danger ms-1">0</span>
										</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link d-inline-flex align-items-center" id="paid-in-progress-tab" data-bs-toggle="tab"
											data-bs-target="#paid-in-progress" type="button" role="tab" aria-controls="paid-in-progress"
											aria-selected="false">درحال ارسال
											<span class="badge rounded-pill bg-danger ms-1">0</span></button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link d-inline-flex align-items-center" id="delivered-tab" data-bs-toggle="tab"
											data-bs-target="#delivered" type="button" role="tab" aria-controls="delivered"
											aria-selected="false">تحویل شده
											<span class="badge rounded-pill bg-danger ms-1">0</span></button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link d-inline-flex align-items-center " id="canceled-tab" data-bs-toggle="tab"
											data-bs-target="#canceled" type="button" role="tab" aria-controls="canceled" aria-selected="true">مرجوعی
											<span class="badge rounded-pill bg-danger ms-1">0</span></button>
									</li>
								</ul>
							</div>
							<!-- end of order-tabs -->
							<!-- start of tab-content -->

							<div class="tab-content" id="myTabContent">
								<!-- start of tab-pane -->
								<!-- start of tab-pane -->
								<div class="tab-pane fade show active" id="wait-for-payment" role="tabpanel"
									aria-labelledby="wait-for-payment-tab">
									<div id="payDone"></div>
									<div class="ui-box-empty-content">
										<div class="ui-box-empty-content-icon">
											<img src="./theme-assets/images/theme/orders.svg" alt="" />
										</div>
										<div class="ui-box-empty-content-message">
											سفارش فعالی در این بخش وجود ندارد.
										</div>
									</div>
								</div>
								<!-- end of tab-pane -->
								<div class="tab-pane fade" id="paid-in-progress" role="tabpanel" aria-labelledby="paid-in-progress-tab">
									<div class="user-order-items">
										<div class="user-order-item">
											<div class="user-order-item-header">
												<div class="mb-3">
													<div class="row">
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta fa-num">تاریخ</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">شماره سفارش</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">سفارش درحال ارسال</span>
														</div>
													</div>
												</div>
												<div>
													<span class="text-muted fw-bold">مبلغ کل:</span>
													<span class="fw-bold fa-num">مبلغ سفارش
														<span>تومان</span></span>
												</div>
												<a href="{{ route('profile.my-order-detail') }}"
													class="btn btn-link fw-bold user-order-detail-link colorBlue">جزئیات
													سفارش <i class="ri-arrow-left-s-fill"></i></a>
											</div>
											<div class="user-order-item-content">
												<div class="mb-3">
													<span class="text-dark fa-num">مرسوله 1 از 1</span>
												</div>
												<div class="user-order-item-products">
													<a href="#">
														<img src="./theme-assets/images/carts/01.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/02.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/03.jpg" alt="">
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end of tab-pane -->
								<!-- start of tab-pane -->
								<div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
									<div class="user-order-items">
										<div class="user-order-item">
											<div class="user-order-item-header">
												<div class="mb-3">
													<div class="row">
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta fa-num">تاریخ</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">شماره سفارش</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">ارسال شده</span>
														</div>
													</div>
												</div>
												<div>
													<span class="text-muted fw-bold">مبلغ کل:</span>
													<span class="fw-bold fa-num">مبلغ سفارش
														<span>تومان</span></span>
												</div>
												<a href="{{ route('profile.my-order-detail') }}"
													class="btn btn-link fw-bold user-order-detail-link colorBlue">جزئیات
													سفارش <i class="ri-arrow-left-s-fill"></i></a>
											</div>
											<div class="user-order-item-content">
												<div class="mb-3">
													<span class="text-dark fa-num">مرسوله 1 از 1</span>
												</div>
												<div class="user-order-item-products">
													<a href="#">
														<img src="./theme-assets/images/carts/01.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/02.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/03.jpg" alt="">
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end of tab-pane -->
								<!-- start of tab-pane -->
								<div class="tab-pane fade" id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
									<div class="user-order-items">
										<div class="user-order-item">
											<div class="user-order-item-header">
												<div class="mb-3">
													<div class="row">
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta fa-num">تاریخ</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">شماره سفارش</span>
														</div>
														<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">
															<span class="user-order-meta">سفارش لغو شده</span>
														</div>
													</div>
												</div>
												<div>
													<span class="text-muted fw-bold">مبلغ کل:</span>
													<span class="fw-bold fa-num">مبلغ سفارش
														<span>تومان</span></span>
												</div>
												<a href="{{ route('profile.my-order-detail') }}"
													class="btn btn-link fw-bold user-order-detail-link colorBlue">جزئیات
													سفارش <i class="ri-arrow-left-s-fill"></i></a>
											</div>
											<div class="user-order-item-content">
												<div class="mb-3">
													<span class="text-dark fa-num">مرسوله 1 از 1</span>
												</div>
												<div class="user-order-item-products">
													<a href="#">
														<img src="./theme-assets/images/carts/01.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/02.jpg" alt="">
													</a>
													<a href="#">
														<img src="./theme-assets/images/carts/03.jpg" alt="">
													</a>
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
			</div>
		</div>
	</main>
@stop

@section('footer')
	@parent
@stop

@section('extraJS')
	@parent
	<script>
		$.ajax({
			type: 'get',
			url: '{{ route('api.getMyOrders', ['statues' => '']) }}',
			headers: {
				'accept': 'application/json'
			},
			success: function(res) {
				console.log(res);
				var payDone = '';
				if (res.status === "ok") {
					if (res.data.length != 0) {
						$('.order-tabs').removeClass('hidden');
						for (var i = 0; i < res.data.length; i++) {
							payDone += '<div class="user-order-items">';
							payDone += '<div class="user-order-item">';
							payDone += '<div class="user-order-item-header">';
							payDone += '<div class="mb-3">';
							payDone += '<div class="row">';
							payDone += '<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">';
							payDone += '<span class="user-order-meta fa-num">تاریخ: ' + res.data[i].created_at +
								'</span>';
							payDone += '</div>';
							payDone += '<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">';
							payDone += '<span class="user-order-meta"> شماره سفارش:' + res.data[i].tracking_code +
								'</span>';
							payDone += '</div>';
							payDone += '<div class="col-xl-3 col-lg-4 col-md-auto col-sm-6">';
							payDone += '<span class="user-order-meta">سفارش درحال ارسال</span>';
							payDone += '</div>';
							payDone += '</div>';
							payDone += '</div>';
							payDone += '<div>';
							payDone += '<span class="text-muted fw-bold">مبلغ کل:</span>';
							payDone += '<span class="fw-bold fa-num">مبلغ سفارش<span>تومان</span></span>';
							payDone += '</div>';
							payDone +=
								'<a href="{{ route('profile.my-order-detail') }}"class="btn btn-link fw-bold user-order-detail-link colorBlue">جزئیات سفارش <i class="ri-arrow-left-s-fill"></i></a>';
							payDone += '</div>';
							payDone += '<div class="user-order-item-content">';
							payDone += '<div class="mb-3">';
							payDone += '<span class="text-dark fa-num">مرسوله 1 از 1</span>';
							payDone += '</div>';
							payDone += '<div class="user-order-item-products">';
							for (var j = 0; j < res.data[i].images.length; j++) {
								payDone += '<a href="#"><img src="' + res.data[i].images[j] +
									'" alt=""></a>';
							}
							payDone += '</div>';
							payDone += '</div>';
							payDone += '</div>';
							payDone += '</div>';

						}
						$("#payDone").empty().append(payDone);
					} else {
						$('#nothingToShow').removeClass('hidden');
					}
				}
			}
		});
	</script>
@stop
