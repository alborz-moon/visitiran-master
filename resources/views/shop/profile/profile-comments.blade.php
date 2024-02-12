@extends('layouts.structure')
@section('content')
	<main class="page-content">
		<div class="container">
			<div class="row mb-5">
				@include('shop.profile.layouts.profile_menu')
				<div class="col-xl-9 col-lg-9 col-md-8">
					<div class="ui-box bg-white mb-5">
						<div class="ui-box-title">نظرات</div>
						<div id="nothingToShow" class="hidden">

							<div style=" height: 180px">
								<img class=" h-100 " src="{{ asset('theme-assets/images/orders.svg') }} "alt="">
							</div>

							<div> موردی برای نمایش موجود نیست</div>

						</div>
						<div class="ui-box-content comments">
							<div class="row" id="commentMy">
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
	<script>
		$.ajax({
			type: 'get',
			url: '{{ request()->getHost() == \App\Http\Controllers\Controller::$EVENT_SITE ? route('api.comment.myevent') : route('api.comment.my') }}',
			headers: {
				'accept': 'application/json'
			},
			success: function(res) {
				var html = "";
				if (res.status === "ok") {
					if (res.data.length != 0) {
						for (var i = 0; i < res.data.length; i++) {
							html += '<div class="col-lg-12 mb-4">';
							html += '<div class="border rounded p-3">';
							html += '<div class="spaceBetween"';
							html += '<div><a href="' + res.data[i].href +
								'" class="d-flex align-items-center colorBlack bold pb-3">';
							html += '<img src="' + res.data[i].img + '" width="30" height="30" alt="">';
							if (res.data[i].product != undefined && res.data[i].product.length != 0) {
								html += '<span class="fs-7 fw-bold px-3">' + res.data[i].product + '</span>';
							} else {
								html += '<span class="fs-7 fw-bold px-3">' + res.data[i].event + '</span>';
							}
							html += '</a>';
							html += '<div class="d-flex align-items-center justify-content-center">';
							if (res.data[i].rate != null) {
								for (var j = 5; j >= 1; j--) {
									if (j <= res.data[i].rate) {
										html += '<i class="icon-visit-star me-1 fontSize21"></i>';
									} else {
										html += '<i class="icon-visit-staroutline me-1 fontSize14"></i>';
									}
								}
							}
							html += '</div></div>';
							html += '<div class="comment">';
							html += '<div class="comment-header"><span> در ' + res.data[i].created_at +
								'</span></div>';
							html += '<div class="comment-body"><p>' + res.data[i].msg + '</p>';
							html += '<ul>';
							for (var j = 0; j < res.data[i].positive.length; j++) {
								html += '<li class="comment-evaluation positive">' + res.data[i].positive[j] +
									'</li>';
							}
							for (var j = 0; j < res.data[i].negative.length; j++) {
								html += '<li class="comment-evaluation negative">' + res.data[i].negative[j] +
									'</li>';
							}
							html += '</ul>';
							html += '</div>';
							html += '<div class="d-flex align-items-center justify-content-end">';
							html +=
								'<a href="#" class="btn btn-link colorRed">حذف <i class="icon-visit-delete colorRed mt-1 ms-1"></i></a>';
							html += '</div>';
							html += '</div>';
							html += '</div>';
							html += '</div>';
						}
						$("#commentMy").empty().append(html);
					} else {
						$('#nothingToShow').removeClass('hidden');
					}
				}
			}
		});
	</script>
@stop
