@extends('layouts.structure')
@section('content')
	<main class="page-content TopParentBannerMoveOnTop">
		<div class="container">
			<div class="row mb-5">
				@include('shop.profile.layouts.profile_menu')
				<div class="col-xl-9 col-lg-8 col-md-7">
					<div class="ui-box bg-white mb-5 p-0">
						<div class="ui-box-title align-items-center justify-content-between">
							تیکتهای شما
							<a href="{{ route('profile.tickets-add') }}" class="btn btn-outline-light marginLeft3">تیکت جدید
								<i class="ri-add-line ms-2"></i>
							</a>
						</div>
						<div id="nothingToShow" class="">
							<div style=" height: 180px">
								<img class=" h-100" src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
							</div>
							<div> موردی برای نمایش موجود نیست</div>
						</div>
						<div class="py-2 hidden">
							<div class="table-responsive dropdown">
								<table class="table mb-0">
									<thead>
										<tr>
											<th>زمان ایجاد</th>
											<th>بخش</th>
											<th>موضوع</th>
											<th>وضعیت</th>
											<th>آخرین بروزرسانی</th>
											<th>عملیات</th>
										</tr>
									</thead>
									<tbody id="myTickets">
										{{-- <tr>
                                            <td>رویداد من</td>
                                            <td>اصغر فرهادی</td>
                                            <td>1401</td>
                                            <td>1402</td>
                                            <td>10</td>
                                            <td>
                                                <button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-visit-menu"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item fontSize12 btnHover" href="#">مشاهده</a></li>
                                                    <li><a class="dropdown-item fontSize12 btnHover" href="#">حذف</a></li>
                                                </ul>
                                            </td>
                                        </tr> --}}
									</tbody>
								</table>
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
