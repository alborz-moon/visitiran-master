@extends('layouts.structure')

@section('content')
	<main class="page-content TopParentBannerMoveOnTop">
		<div class="container">
			<div class="row mb-5">
				@include('event.launcher.launcher-menu')
				<div class="col-xl-9 col-lg-9 col-md-8">
					<div class="ui-box bg-white mb-5 boxShadow p-0">
						<div class="ui-box-title">رویداد ها</div>
						<div class="ui-box-content">
							<div class="row">
								<div id="nothingToShow" class="hidden">

									<div style=" height: 180px">
										<img class=" h-100 " src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
									</div>

									<div> موردی برای نمایش موجود نیست</div>

								</div>
								<div id="hiddenTable" class="col-lg-12 mb-3">
									<div class="py-2">
										<div class="ui-box bg-white mb-5 p-0">
											<div class="table-responsive dropdown">
												<table class="table mb-0 ">
													<thead>
														<tr>
															<th>ردیف</th>
															<th>نام رویداد</th>
															<th>نام برگزار کننده</th>
															<th>تاریخ شروع</th>
															<th>تاریخ ثبت نام</th>
															<th>تعداد بلیت</th>
															<th>عملیات</th>
														</tr>
													</thead>
													<tbody id="myEvents"></tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@stop

@section('extraJS')
	@parent
	<script>
		$.ajax({
			type: 'get',
			url: '{{ route('api.my-events') }}',
			headers: {
				'accept': 'application/json'
			},
			success: function(res) {
				if (res.status === "ok") {
					var myEvents = "";
					if (res.data.length != 0) {
						$('#nothingToShow').addClass('hidden');
						for (var i = 0; i < res.data.length; i++) {
							myEvents += '<tr>';
							myEvents += '<td>' + (i + 1) + '</td>';
							myEvents += '<td>' + res.data[i].title + '</td>';
							myEvents += '<td>' + res.data[i].launcher + '</td>';
							myEvents += '<td>' + res.data[i].created_at + '</td>';
							myEvents += '<td>' + res.data[i].start + '</td>';
							myEvents += '<td>' + res.data[i].count + '</td>';
							myEvents += '<td>';
							myEvents +=
								'<button class="btn btn-circle borderCircle my-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
							myEvents += '<i class="icon-visit-menu"></i>';
							myEvents += '</button>';
							myEvents += '<ul class="dropdown-menu">';
							myEvents += '<li><a class="dropdown-item fontSize12 btnHover" href="' + res.data[i]
								.href + '">مشاهده</a></li>';
							myEvents += '<li><a class="dropdown-item fontSize12 btnHover" href="' + res.data[i]
								.ticket_href + '">بلیت</a></li>';
							myEvents += '<li><a class="dropdown-item fontSize12 btnHover" href="' + res.data[i]
								.recp_href + '">فاکتور</a></li>';
							myEvents += '<li><a class="dropdown-item fontSize12 btnHover" href="' + res.data[i]
								.recp_href + '">فاکتور</a></li>';
							myEvents +=
								'<li><a class="dropdown-item fontSize12 btnHover" href="{{ route('profile.my-tickets') }}">پشتیبانی</a></li>';
							myEvents += '</ul>'
							myEvents += '</td>';
							myEvents += '</tr>';
						}
						$("#myEvents").empty().append(myEvents);
					} else {
						showErr("موردی برای نمایش وجود ندارد")
						$('#nothingToShow').removeClass('hidden');
						$('#hiddenTable').addClass('hidden');
					}
				}
			}
		});
	</script>
@stop
