@extends('layouts.structure')
@section('content')
	<main class="page-content TopParentBannerMoveOnTop">
		<div class="container">
			<div class="row mb-5">
				<div id="nothingToShow" class="hidden">
					<div style=" height: 180px">
						<img class=" h-100 " src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
					</div>
					<div> موردی برای نمایش موجود نیست</div>
				</div>
				@include('shop.profile.layouts.profile_menu')
				<div class="col-xl-9 col-lg-8 col-md-7">
					<div class="ui-box bg-white mb-5 p-0">
						<div class="ui-box-title">تراکنش های من</div>
						<div class="ui-box-content p-0 ">
							<div class="product-list p-0">
								<div class="table-responsive dropdown">
									<table class="table mb-0">
										<thead>
											<tr>
												<th>ردیف</th>
												<th>نام رویداد</th>
												<th>تعداد بلیط</th>
												<th>مبلغ</th>
												<th>تاریخ</th>
												<th>شماره تراکنش</th>
												<th>نوع پرداخت</th>
												<th>عملیات</th>
											</tr>
										</thead>
										<tbody id="myTransaction" class="hidden">
											<tr>
												<td>1</td>
												<td>رویداد من</td>
												<td>2</td>
												<td>12.000</td>
												<td>1401.14.01</td>
												<td>12012545823486</td>
												<td>10101010</td>
												<td>
													<button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown"
														aria-expanded="false">
														<i class="icon-visit-menu"></i>
													</button>
													<ul class="dropdown-menu">
														{{-- <li><a class="dropdown-item fontSize12 btnHover" href="#"></a></li> --}}
														<li><a class="dropdown-item fontSize12 btnHover" href="#">مشاهده
																فاکتور</a></li>
													</ul>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
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
@stop
