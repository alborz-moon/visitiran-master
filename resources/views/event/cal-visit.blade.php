@extends('layouts.structure')
@section('header')
	@parent
	<link rel="stylesheet" href="{{ URL::asset('theme-assets/bootstrap-datepicker.css?v=1') }}">
	<link rel="stylesheet" href="{{ URL::asset('theme-assets/css/dependencies/calender.css') }}">
	<script src="{{ URL::asset('theme-assets//bootstrap-datepicker.js') }}"></script>
@stop
@section('content')
	<main class="page-content TopParentBannerMoveOnTop">
		<div class="w-100  marginTopNegative5">
			<div class="w-100 backgroundWhite container pb-1 pt-3 ">

				<div class="accordion backgroundWhite" id="accordionPanelsStayOpenExample">
					<div class="accordion-item backgroundWhite">
						<h2 class="accordion-header backgroundWhite" id="panelsStayOpen-headingOne">
							<button class="accordion-button w-100 p-1 backgroundWhitee" style="background-color: #eaeaea!important"
								type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
								aria-controls="panelsStayOpen-collapseOne">
								<span class="ui-box-title fontSize20 mb-3 backgroundWhite">
									<img class="p-2 backgroundWhite" src="http://myshop.com/./theme-assets/images/svg/headlineTitle.svg"
										alt="">
									رویداد خود را بیابید
								</span>
							</button>
						</h2>
						<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show "
							aria-labelledby="panelsStayOpen-headingOne">
							<div class="accordion-body backgroundWhite">
								<div class="row ">
									<div class="col-xs-12 col-md-2 marginBottom5">
										<input type="text" class="form-control customBackgroundWhite w-100" placeholder="نام رویداد">
									</div>
									<div class="col-xs-12 col-md-2 marginBottom5">
										<select class="select2 seachbar-select" aria-placeholder="" id="launcherFilter">
											<option selected value="0">نوع رویداد</option>
										</select>
									</div>
									<div class="col-xs-12 col-md-2 marginBottom5">
										<select class="select2 seachbar-select" aria-placeholder="" id="cityFilter">
											<option selected value="0">محل برگزاری</option>
										</select>
									</div>
									<div class="col-xs-12 col-md-4 marginBottom5">
										<label class="tripCalenderSection w-100">
											<span class="calendarIcon"></span>
											<input id="date_input_launcher" class="tripDateInput form-control customBackgroundWhite w-100"
												placeholder="تاریخ برگزاری" required readonly type="text">
										</label>
									</div>
									<div class="col-xs-12 col-md-2 marginBottom5">
										<button onclick="goToListPage()" class="btn btn-primary whiteSpaceNoWrap w-100">جست و جو</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input id="date_input_start_formatted_search" type="hidden" />
			<!-- start-container -->
			<div class="container ">
				<div class="w-100  backgroundWhite mt-3 spaceBetween alignItemsCenter dateTopicBox">
					<div class="d-flex alignItemsCenter flexDirectionColumn">
						<div class="d-flex ">

							<i class="icon-visit-date colorYellow fontSize30 px-2"></i>
							<div>

								<div class="d-flex fontSize14 bold whiteSpaceNoWrap advanceFilter"> پنج شنبه 21 اردیبهشت ماه 1401</div>
								<div class="d-flex fontSize12 bold colorRed px-2">تعطیل رسمی</div>
							</div>
						</div>
						<div>
							<button class="btn btn-primary d-md-none toggle-responsive-sidebar advanceFilterBtn">فیلتر
								پیشرفته
								<i class="ri-equalizer-fill ms-1"></i>
							</button>
						</div>
					</div>

					<ul class="nav nav-pills d-flex alignItemsCenter tabPaneCal noWrap moblieCal" id="pills-tab" role="tablist">
						<li class="nav-item d-flex alignItemsCenter whiteSpaceNoWrap" role="presentation">
							<button class="active b-0 backgroundWhite" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
								type="button" role="tab" aria-controls="pills-home" aria-selected="true">رویداد های امروز</button>
							<span class="mx-2" style="width: 1px;background-color: #c0c0c0;height: 49px"></span>
						</li>
						<li class="nav-item d-flex alignItemsCenter" role="presentation">
							<button class="b-0 backgroundWhite" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
								type="button" role="tab" aria-controls="pills-profile" aria-selected="false">روزانه</button>
							<span class="mx-2" style="width: 1px;background-color: #c0c0c0;height: 49px"></span>
						</li>
						<li class="nav-item d-flex alignItemsCenter mr-2" role="presentation">
							<button class=" b-0 backgroundWhite" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
								type="button" role="tab" aria-controls="pills-contact" aria-selected="false">ماهیانه</button>
						</li>
					</ul>
				</div>
				<div class="row">

					<div class="col-xl-3 col-lg-3 col-md-4 responsive-sidebar mt-md-4 mt-sm-0" style="margin-top: -5px">

						<div class="ui-sticky ui-sticky-top StickyMenuMoveOnTop zIndex0">
							<div class="ui-box sidebar-widgets customFilter">
								<!-- start of widget -->
								<div class="widget mb-3">
									<div class="spaceBetween">
										<div class="widget-title m-0 b-0">فیلتر
											<span id="total_filters" class="fontSize12 colorBlue hidden">
												<span id="total_filters_count"></span>
												<span>فیلتر</span>
											</span>
										</div>
										<a id="remove_all_filters" onclick="clearAllFilters()"
											class="hidden colorRed cursorPointer fontSize12 align-self-center">حذف نتایج</a>
									</div>
									<div id="total_count" class="colorBlue fontSize12 align-self-center"></div>

								</div>
								<!-- start of widget -->
								<div class="widget widget-collapse mb-3">
									<div class="widget-title widget-title--collapse-btn d-flex gap10 align-items-center" data-bs-toggle="collapse"
										data-bs-target="#collapseGroupingStar" aria-expanded="false" aria-controls="collapseGroupingStar"
										role="button">دسته بندی
										<div id="star_filters_count_container" class="hidden">
											<i class="circle colorBlue align-self-center"></i>
											<span class="colorBlue fontSize12">
												<span id="star_filters_count"></span><span> فیلتر</span>
											</span>
										</div>
									</div>
									<div class="widget-content widget--search collapse" id="collapseGroupingStar">
										<div class="filter-options do-simplebar pt-2 mt-2">
											<div>
												<li class="form-check">
													<input class="form-check-input" type="checkbox" />
													مناسبت های تقویمی
												</li>
												<li class="form-check">
													<input class="form-check-input" type="checkbox" />
													مناسبت های ملی
												</li>
												<li class="form-check">
													<input class="form-check-input" type="checkbox" />
													رویدادها
												</li>
											</div>
										</div>
									</div>
								</div>
								<!-- end of widget -->

								<!-- start of widget -->
								<div class="widget widget-collapse mb-3">
									<div class="widget-title widget-title--collapse-btn d-flex gap10 align-items-center" data-bs-toggle="collapse"
										data-bs-target="#collapseGroupingCity" aria-expanded="false" aria-controls="collapseGroupingCity"
										role="button">محل برگزاری

										<div id="cities_filters_count_container" class="hidden">
											<i class="circle colorBlue align-self-center"></i>
											<span class="colorBlue fontSize12">
												<span id="cities_filters_count"></span><span> فیلتر</span>
											</span>
										</div>

									</div>
									<div class="widget-content widget--search collapse" id="collapseGroupingCity">

										<div class="filter-options do-simplebar pt-2 mt-2">
											<div id="levels">
											</div>
										</div>

									</div>
								</div>
								<!-- end of widget -->
								<!-- start of widget -->
								<div class="widget py-1 mb-3">
									<div class="widget-content widget--filter-switcher">
										<div class="form-check form-switch mb-0">
											<input class="form-check-input" type="checkbox" id="has_selling_offs">
											<label clas="form-check-label" for="has_sellingoffs">فقط آنلاین
											</label>
										</div>
									</div>
								</div>
								<!-- end of widget -->
								<!-- start of widget -->
								<div class="widget py-1 mb-3">
									<div class="widget-content widget--filter-switcher">
										<label class="form-check-label widget-title b-0" for="has_sellingoffs">محدوده زمانی
										</label>
										<div class="d-flex alignItemsCenter p-1">
											<div id="date_btn_start_edit" class="label fs-7 font600 px-2">از</div>
											<label class="tripCalenderSection w-100">
												<input style="direction: rtl" id="date_input_start"
													class="tripDateInput w-100 form-control directionLtr backColorWhite" placeholder="تاریخ شروع" required
													readonly type="text">
											</label>
										</div>
										<div class="d-flex alignItemsCenter p-1">
											<div id="date_btn_start_edit" class="label fs-7 font600 px-2">تا</div>
											<label class="tripCalenderSection w-100">
												<input style="direction: rtl" id="date_input_stop"
													class="tripDateInput w-100 form-control directionLtr backColorWhite" placeholder="تاریخ پایان" required
													readonly type="text">
											</label>
										</div>

									</div>
								</div>
								<!-- end of widget -->

							</div>
						</div>
					</div>
					<div class="col-xl-9 col-lg-9 col-md-8 px-0">
						<div style="display:none " class="d-md-none">
							<div class="d-flex justifyContentSpaceBetween alignItemsCenter p-2">
								<div>
									<button class="btn btn-primary d-md-none toggle-responsive-sidebar ">فیلتر پیشرفته
										<i class="ri-equalizer-fill ms-1"></i>
									</button>
									<span id="total_filters_count_mobile" class="remove_all_filters me-1 colorBlue fontSize12"></span><span
										class="remove_all_filters colorBlue fontSize12">فیلتر</span>
								</div>
								<div>
									<a onclick="clearAllFilters()"
										class="colorRed cursorPointer fontSize12 align-self-center remove_all_filters hidden">حذف
										نتایج</a>
								</div>
							</div>
						</div>
						<div class="listing-products">
							<div class="listing-products-content">
								<!-- start of tab-content -->
								<div class="tab-content marginTopNegative5" id="sort-tabContent">
									<!-- start of tab-pane -->
									<div class="tab-pane fade show active mt-4" id="most-visited" role="tabpanel"
										aria-labelledby="most-visited-tab">
										<div class="p-1 mb-4">
											<div class="ui-box-content p-0">
												<div class="row mx-0">
													<div class="tab-content p-0" id="pills-tabContent">
														<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
															aria-labelledby="pills-home-tab">
															<div class="d-flex alignItemsCenter p-1 gap10 ">

																<div class="col-xl-11 col-lg-11">
																	<div class="mobileDataTopic">

																		<div class="d-flex  boxShadow ">
																			<div class=" fontSize12 p-1  colorWhite px-3 backgroundColorYellow">پنج شنبه</div>
																			<div class=" fontSize14 bold p-1">21</div>
																			<div class="fontSize14 p-1">اردیبهشت</div>
																		</div>
																	</div>
																	<div class="d-flex alignItemsCenter p-1 gap10 ">
																		<div class="boxShadow backgroundColorWhite position-relative">
																			<div class="d-flex cardCal">
																				<img width="210" style=" max-height:210px" class="objectFitCover p-1 borderRadius10 imgcal"
																					src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCosNE8U8r4l6IY0NHJ7icaHynM8gFLQimNg&usqp=CAU alt="">
																				<div class="p-2">
																					<div class="d-flex justifyContentSpaceBetween changeCal ">
																						<div class="fontSize20">رویداد
																							های امروز </div>
																						<div class="l-0 colorWhite px-3 backgroundColorYellow" style="height: 22px;width:120.22px">
																							مناسبت
																							تقویمی</div>
																					</div>
																					<p>
																						با تولید سادگی نامفهوم از صنعت
																						چاپ و با استفاده از طراحان
																						گرافیک است. چاپگرها و متون بلکه
																						روزنامه
																						و
																						مجله در ستون و سطرآنچنان که لازم
																						است و برای شرایط فعلی تکنولوژی
																						مورد نیاز و کاربردهای متنوع با
																						هدف
																						بهبود ابزارهای کاربردی می باشد.
																						کتابهای زیادی در شصت و سه درصد
																						گذشته، حال و آینده شناخت فراوان
																						جامعه
																						و
																						متخصصان را می طلبد تا با نرم
																						افزارها شناخت بیشتری را برای
																						طراحان رایانه ای علی الخصوص
																						طراحان خلاقی
																						و
																						فرهنگ پیشرو در زبان فارسی ایجاد
																						کرد. در این
																					</p>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="d-flex flexDirectionColumn gap15 dateTopic">
																	<div style="width: 53px;height: 53px;border-radius:0" class="boxShadow overFlowHidden">
																		<div style="height: 20px;border-radius: 0;"
																			class="backgroundColorYellow colorWhite fontSize12 w-100 overFlowHidden d-flex justifyContentCenter">
																			پنج شنبه</div>
																		<div class="d-flex justifyContentCenter fontSize20" style="margin-top: -5px">21
																		</div>
																		<div class="d-flex justifyContentCenter fontSize12" style="margin-top: -12px">
																			اردیبهشت</div>
																	</div>
																	<div style="width: 53px;height: 53px;border-radius:0" class="boxShadow overFlowHidden">
																		<div style="height: 20px;border-radius: 0;"
																			class="backgroundColorRed colorWhite fontSize12 w-100 overFlowHidden d-flex justifyContentCenter">
																			جمعه </div>
																		<div class="d-flex justifyContentCenter fontSize20" style="margin-top: -5px">22
																		</div>
																		<div class="d-flex justifyContentCenter fontSize12" style="margin-top: -12px">
																			اردیبهشت</div>
																	</div>
																</div>
															</div>
															<div class="mobileDataTopic">

																<div class=" d-flex justifyContentCenter">
																	<div class="d-flex  boxShadow w-50pr">
																		<div class=" fontSize12 p-1  colorWhite px-3 backgroundColorYellow">پنج شنبه</div>
																		<div class=" fontSize14 bold p-1">21</div>
																		<div class="fontSize14 p-1">اردیبهشت</div>
																	</div>
																	<div class="d-flex  boxShadow w-50pr ">
																		<div class=" fontSize12 p-1  colorWhite px-3 backgroundColorRed"> جمعه</div>
																		<div class=" fontSize14 bold p-1">22</div>
																		<div class="fontSize14 p-1">اردیبهشت</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
															<div class="d-flex alignItemsCenter p-1 gap10">
																<div class="col-xl-11 col-lg-12">
																	<div class="d-flex alignItemsCenter p-1 gap10 marginBottom30 ">
																		<div class="boxShadow backgroundColorWhite position-relative">
																			<div class="d-flex cardCal">
																				<img width="210" style=" max-height:210px" class="objectFitCover p-1 borderRadius10 imgcal"
																					src="data:image/jpeg;base64,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																			alt="">
																				<div class="p-2">
																					<div class="d-flex justifyContentSpaceBetween changeCal ">
																						<div class="fontSize20">رویداد
																							های امروز </div>
																						<div class="l-0 colorWhite px-3 backgroundColorYellow" style="height: 22px;width:120.22px">
																							مناسبت
																							تقویمی</div>
																					</div>
																					<p>
																						با تولید سادگی نامفهوم از صنعت
																						چاپ و با استفاده از طراحان
																						گرافیک است. چاپگرها و متون بلکه
																						روزنامه
																						و
																						مجله در ستون و سطرآنچنان که لازم
																						است و برای شرایط فعلی تکنولوژی
																						مورد نیاز و کاربردهای متنوع با
																						هدف
																						بهبود ابزارهای کاربردی می باشد.
																						کتابهای زیادی در شصت و سه درصد
																						گذشته، حال و آینده شناخت فراوان
																						جامعه
																						و
																						متخصصان را می طلبد تا با نرم
																						افزارها شناخت بیشتری را برای
																						طراحان رایانه ای علی الخصوص
																						طراحان خلاقی
																						و
																						فرهنگ پیشرو در زبان فارسی ایجاد
																						کرد. در این
																					</p>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="ui-sticky ui-sticky-top StickyMenuMoveOnTop zIndex0 alignSelfStart">
																	<div style="width: 53px;height: 53px;border-radius:0" class="boxShadow overFlowHidden">
																		<div style="height: 20px;border-radius: 0;"
																			class="backgroundColorYellow colorWhite fontSize12 w-100 overFlowHidden d-flex justifyContentCenter">
																			پنج شنبه</div>
																		<div class="d-flex justifyContentCenter fontSize20" style="margin-top: -5px">21
																		</div>
																		<div class="d-flex justifyContentCenter fontSize12" style="margin-top: -12px">
																			اردیبهشت</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
															<div class="container">
																<div class="row">
																	<div class="mobileDataTopic">

																		<div class="d-flex  boxShadow ">
																			<div class=" fontSize12 p-1  colorWhite px-3 backgroundColorYellow">پنج شنبه</div>
																			<div class=" fontSize14 bold p-1">21</div>
																			<div class="fontSize14 p-1">اردیبهشت</div>
																		</div>
																	</div>
																	@include('event.layouts.card-calender')
																	@include('event.layouts.card-calender')
																	@include('event.layouts.card-calender')
																</div>
															</div>

														</div>
													</div>
												</div>
											</div>
										</div>

										<!-- end of tab-pane -->
									</div>
								</div>
							</div>
							<div class="responsive-sidebar-overlay"></div>
						</div>
					</div>
				</div>
				<!-- end-container -->
			</div>
		</div>
	</main>

	<input id="date_input_start_formatted" type="hidden" />
	<input id="date_input_stop_formatted" type="hidden" />
@stop

@section('extraJS')
	@parent
	<script>
		var dateStart = '';
		var dateStop = '';

		var datePickerOptions = {
			numberOfMonths: 1,
			showButtonPanel: true,
			dateFormat: "DD d M سال yy",
			altFormat: "yy/mm/dd",
			altField: $("#date_input_start_formatted_search")
		};

		$("#date_input_launcher").datepicker(datePickerOptions);

		var datePickerOptionsStart = {
			numberOfMonths: 1,
			showButtonPanel: true,
			dateFormat: "DD d M سال yy",
			altFormat: "yy/mm/dd",
			altField: $("#date_input_start_formatted")
		};

		var datePickerOptionsEnd = {
			numberOfMonths: 1,
			showButtonPanel: true,
			dateFormat: "DD d M سال yy",
			altFormat: "yy/mm/dd",
			altField: $("#date_input_stop_formatted")
		};

		$("#date_input_start").datepicker(datePickerOptionsStart);
		$("#date_input_stop").datepicker(datePickerOptionsEnd);

		function goToListPage() {

			let query = new URLSearchParams();

			let tag = $('#tagFilter').val();
			let launcher = $('#launcherFilter').val();
			let city = $('#cityFilter').val();

			if (tag != 0)
				query.append('tag', tag);

			if (launcher != 0)
				query.append('launcher', launcher);

			if (city != 0)
				query.append('city', city);

			document.location.href = '{{ route('event.category.list', ['orderBy' => 'createdAt']) }}' + "?" + query
				.toString();
		}
	</script>
@stop
