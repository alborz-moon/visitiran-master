@extends('layouts.structure')
@section('header')
@parent
    <script>
        const myArray = [
            'rgba(255, 99, 132)',
            'rgba(54, 162, 235)',
            'rgba(255, 206, 86)',
            'rgba(75, 192, 192)',
            'rgba(153, 102, 255)',
            'rgba(255, 159, 64)'
        ];
    </script>
    <script src="{{ URL::asset('theme-assets/js/moment.js') }}"></script>
    <script src="{{ URL::asset('theme-assets/js/moment-jalaali.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('theme-assets/css/bootstrap-material-datetimepicker.css') }}">
    <script src="{{ URL::asset('theme-assets/js/bootstrap-material-datetimepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('theme-assets/bootstrap-datepicker.css?v=1') }}">
    <script src="{{ URL::asset('theme-assets/bootstrap-datepicker.js') }}"></script>
    <link href="{{ asset('theme-assets/js/chartjs/chart.min.js') }}" />
    <script src="{{ asset('theme-assets/js/chartjs/chart.min.js') }}"></script>
    <style>
        .remodal {
            max-width: 1000px;
        }
        .select2-results__option--selectable, .select2-selection__rendered {
            text-align: right;
        }
        @media only screen and (min-width: 400px) {
            .remodal {
                overflow: hidden;
                height:80vh ;
            }
        }
        @media only screen and (max-width: 400px) {
            .remodal {
                overflow: hidden;
                height:90% ;
            }
        }
    </style>

@stop
@section('content')
<main class="page-content TopParentBannerMoveOnTop" style="overflow:hidden " >
    <div class="container">
    <div class="row mb-5">
    @include('shop.profile.layouts.profile_menu')
    <div class="col-xl-9 col-lg-8 col-md-7">
        <div class=" ui-box bg-white mb-5 p-0 py-2">
            <div class="spaceBetween  bg-white mb-5 p-0 py-2">
                <div class="ui-box-title align-items-center justify-content-between">
                    گزارشات مالی
                </div>
                <div class="width250" id="all_events">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-12 ">
                        <div class="positionRelative boxShadow p-3 height190 d-flex alignItemsEnd justifyContentCenter"
                            style="align-items: end">
                            <div
                                class="positionAbsolute backgroundYellow colorWhite border fontSize12 borderRadius10 p-2 top17 r-4">
                                مانده تسویه
                            </div>
                            <div class="mt-1 " style="align-items: center">
                                <div class="p-1 fontSize21 bold"><span id="can_back"></span> ت</div>
                                <div class=" ">
                                    <div class="fontSize12 textColor p-1 ">
                                        حداقل تسویه: 150/000 ت
                                    </div>
                                    <button class="fontSize16  btn btn-primary p-1 "> درخواست تسویه
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 ">
                        <div class=" flexCenter positionRelative boxShadow p-3 height190">
                            <div
                                class="positionAbsolute backgroundYellow colorWhite border fontSize12 borderRadius10 p-2 top17 r-4">
                                درآمد / رویداد
                            </div>
                            <canvas class="myChart"></canvas>
                            <button class="hidden" data-remodal-target="chart-modal" id="showBigPieChartBtn"></button>
                            <button
                                id="prepareBigPieChartBtn"
                                class="positionAbsolute moreChart colorWhite border fontSize12 borderRadius10  btn btn-primary ">
                            بیشتر
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-12 ">
                        <div class=" spaceBetween positionRelative flexDirectionColumn boxShadow p-3 height190">
                            <div
                                class="positionAbsolute backgroundYellow colorWhite border fontSize12 borderRadius10 p-2 top17 r-4 mb-1">
                                آمار کل 
                            </div>
                            <div class="spaceBetween gap15 fontNormal mb-1 pt-4">
                                <div class="fontSize16">کل رویدادها</div>
                                <div class="fontSize14 colorYellow"><span id="events_count"></span><span>&nbsp;</span><span>رویداد</span></div>
                            </div>
                            <div class="spaceBetween gap15 fontNormal mb-1">
                                <div class="fontSize16">کل فروش</div>
                                <div class="fontSize14 colorYellow"><span id="total_paid"></span> ت</div>
                            </div>
                            <div class="spaceBetween gap15 fontNormal mb-1">
                                <div class="fontSize16">کل تسویه</div>
                                <div class="fontSize14 colorYellow"><span id="total_back"></span> ت</div>
                            </div>
                            <div class="spaceBetween gap15 fontNormal mb-1">
                                <div class="fontSize16">کل ثبت نام</div>
                                <div class="fontSize14 colorYellow"><span id="total_registry"></span> نفر</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-box bg-white mb-5 p-0">
			<div class="col-xl-12 col-lg-12 ">
				<div class="accordion" id="accordionExample">
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="headingOne">
				      <button class="accordion-button py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				        گزارشات تفکیکی
				      </button>
				    </h2>
				    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				      <div class="accordion-body">
				        <div class="d-flex justifyContentEnd">
                            <div>
                                <label class="tripCalenderSection w-100">
                                <input id="date_input_start_in_accordion"
                                    class="tripDateInput w-100 form-control directionLtr backColorWhite"
                                    placeholder="تاریخ شروع" required readonly type="text">
                                </label>
                            </div>
                            <div>
                                <label class="tripCalenderSection w-100">
                                <span class="calendarIcon"></span>
                                <input id="date_input_stop_in_accordion"
                                    class="tripDateInput w-100 form-control directionLtr backColorWhite"
                                    placeholder="تاریخ پایان" required readonly type="text">
                                </label>
                            </div>
                        </div>
                        <div>
                            <canvas dir="rtl" id="myChartLineInAccordion"></canvas>
                        </div>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
        <div class="ui-box bg-white mb-5 p-0">
            <div class="col-xl-12 col-lg-12 ">
                <div class="ui-box bg-white mb-5 p-0">
                    <div class="ui-box-title align-items-center justify-content-between">
                        <div>گزارشات تفکیکی</div>
                        <div class="spaceBetween">
                            <div>
                                <label class="tripCalenderSection w-100">
                                <input id="date_input_start"
                                    class="tripDateInput w-100 form-control directionLtr backColorWhite"
                                    placeholder="تاریخ شروع" required readonly type="text">
                                </label>
                            </div>
                            <div>
                                <label class="tripCalenderSection w-100">
                                <span class="calendarIcon"></span>
                                <input id="date_input_stop"
                                    class="tripDateInput w-100 form-control directionLtr backColorWhite"
                                    placeholder="تاریخ پایان" required readonly type="text">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <canvas dir="rtl" id="myChartLine"></canvas>
                    </div>
                    {{-- <div class="py-2">
                        <div class="table-responsive dropdown">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام رویداد</th>
                                        <th>تاریخ</th>
                                        <th>نام خریداد</th>
                                        <th>تعداد</th>
                                        <th>مبلغ </th>
                                    </tr>
                                </thead>
                                <tbody id="stats_table">
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- start of personal-info-birth-modal -->
    <div class="remodal  modal-fumodal-dialog modal-fullscreen-xxl-down " data-remodal-id="chart-modal" data-remodal-options="hashTracking: false">
        <div class="remodal-header">
            <div class="remodal-title">درآمد / رویداد</div>
            <button data-remodal-action="close" class="remodal-close"></button>
        </div>
        <div style="min-height: 300px; height:90%" class="p-1">
            <canvas id="myChartAll"></canvas>
        </div>
    </div>
    <!-- end of personal-info-birth-modal -->
</main>

<input id="date_input_start_formatted" type="hidden" />
<input id="date_input_stop_formatted" type="hidden" />

<input id="date_input_start_formatted_in_accordion" type="hidden" />
<input id="date_input_stop_formatted_in_accordion" type="hidden" />

@stop

@section('extraJS')
@parent

<script>
    var datePickerOptions = {
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
    
    var datePickerOptionsInAccordion = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "DD d M سال yy",
        altFormat: "yy/mm/dd",
        altField: $("#date_input_start_formatted")
    };
    
    var datePickerOptionsEndInAccordion = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "DD d M سال yy",
        altFormat: "yy/mm/dd",
        altField: $("#date_input_stop_formatted")
    };
    
    $(document).ready(function() {
        $("#date_input_start").datepicker(datePickerOptions);
        $("#date_input_stop").datepicker(datePickerOptionsEnd);
        $("#date_input_start_in_accordion").datepicker(datePickerOptionsInAccordion);
        $("#date_input_stop_in_accordion").datepicker(datePickerOptionsEndInAccordion);
    });
    
    var width = window.innerWidth;
    
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    
    $(document).on('click', '#prepareBigPieChartBtn', function() {
        prepareBigPieChart();
    });

    let all_events;
    
    function prepareBigPieChart() {
                                
        let colors = [];
        for(let i = 0; i < all_events.length; i++)
            colors.push(getRandomColor());
                    
        var myChart = new Chart($("#myChartAll"), {
            type: 'pie',
            data: {
                labels: all_events.map(elem => {return elem.title; }),
                datasets: [{
                    label: '# of Votes',
                    data: all_events.map(elem => {return elem.total_pay; }),
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive:true,
                legend: {
                    reverse: true,
                    display: true,
                    position: width > 1200 ? 'right' : 'bottom',
                    align: 'start',
                    labels: {
                        usePointStyle: true,
                        useBorderRadius: true,
                        borderRadius: 50,
                        fontFamily: "IRANSans",
                        fontSize: 10,
                        boxWidth: 15,
                        fontColor: '#111',
                        margin: 20,
                        padding: 15,
                    }
                }
            }
        });

        $("#showBigPieChartBtn").click();
    }

    $(document).on('change', '#event_select', function() {
        filter();
    });

    $(document).on('change', '#date_input_start', function() {
        filter();
    });

    $(document).on('change', '#date_input_stop', function() {
        filter();
    });

    function filter() {
        
        let eventId = $("#event_select").val();
        let start = $("#date_input_start_formatted").val();
        let end = $("#date_input_stop_formatted").val();
        
        let query = new URLSearchParams();

        if(eventId !== undefined && eventId != 0)
            query.append("eventId", eventId);

        if(start !== undefined && start.length > 0)
            query.append("start", start);
            
        if(end !== undefined && end.length > 0)
            query.append("end", end);

        $.ajax({
            type: 'get',
            url: '{{ route('registry_report') }}' + "?" + query.toString(),
            success: function(res) {
    
                if(res.status !== 'ok') {
                    return;
                }
                
                let html = '';
                let counter = 1;

                drawLineChart(res.stats);

                for(let j = 0; j < res.events.length; j++) {

                    for(let i = 0; i < res.events[j].length; i++) {

                        html += '<tr>';
                        html += '<td>' + counter + '</td>';
                        html += '<td>' + res.events[j][i].title + '</td>';
                        html += '<td>' + res.events[j][i].date + '</td>';
                        html += '<td>' + res.events[j][i].buyer + '</td>';
                        html += '<td>' + res.events[j][i].count + '</td>';
                        html += '<td>' + res.events[j][i].amount + '</td>';
                        html += '</tr>';
                        counter++;
                    }
                }

                $("#stats_table").empty().append(html);
            }

        });
    }


    $(document).ready(function() {

        $.ajax({
            type: 'get',
            url: '{{ route('generalStats') }}',
            success: function(res) {
    
                if(res.status !== 'ok') {
                    return;
                }
    
                $("#events_count").append(res.events.length);
                $("#total_paid").append(res.total_pay);
                $("#total_registry").append(res.total_registry);
                $("#total_back").append(res.total_back);
                $("#can_back").append(res.can_back);
    
                all_events = res.events;
                if(all_events.length <= 5)
                    $("#prepareBigPieChartBtn").remove();

                drawLineChart(res.stats);

                let colors = [];
                for(let i = 0; i < Math.min(5, res.events.length); i++)
                    colors.push(getRandomColor());
    
                var ctx = $(".myChart");
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: res.events.slice(0, colors.length).map(elem => {return "substr___" + elem.title; }),
                        datasets: [{
                            label: '# of Votes',
                            data: res.events.slice(0, colors.length).map(elem => {return elem.total_pay; }),
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            reverse: true,
                            display: true,
                            position: 'right',
                            align: 'start',
                            labels: {
                                usePointStyle: true,
                                useBorderRadius: true,
                                borderRadius: 50,
                                fontFamily: "IRANSans",
                                fontSize: 10,
                                boxWidth: 20,
                                fontColor: '#111',
                                padding: 10,
                            }
                        }
                    }
                });
                
                let html = '';
                let select = '';
                let counter = 1;

                select += '<select id="event_select" class="select2">';
                select += '<option style="text-align: right" value="0" selected>نام رویداد</option>';

                for(let j = 0; j < all_events.length; j++) {

                    select += '<option value="' + all_events[j].id + '">' + all_events[j].title + '</option>';

                    for(let i = 0; i < all_events[j].buyers.length; i++) {

                        html += '<tr>';
                        html += '<td>' + counter + '</td>';
                        html += '<td>' + all_events[j].buyers[i].title + '</td>';
                        html += '<td>' + all_events[j].buyers[i].date + '</td>';
                        html += '<td>' + all_events[j].buyers[i].buyer + '</td>';
                        html += '<td>' + all_events[j].buyers[i].count + '</td>';
                        html += '<td>' + all_events[j].buyers[i].amount + '</td>';
                        html += '</tr>';
                        counter++;
                    }
                }

                select += '</select>';

                $("#all_events").append(select);
                $('.select2').select2();
                $("#stats_table").append(html);

            }
        });
    
    });
    
    function drawLineChart(stats) {

        var ctx = $(".myChart");
        new Chart(document.getElementById("myChartLine"), {
            type: 'line',
            data: {
                labels: stats.map(elem => { 

                    if(typeof elem.date === 'number')
                        return (elem.date + "").substr(0, 4) + "/" + (elem.date + "").substr(4, 2) + "/" + (elem.date + "").substr(6, 2);

                    return elem.date;
                }),
                datasets: [{
                    data: stats.map(elem => { return elem.count; }),
                    borderColor: "#3e95cd",
                    fill: false
                }, ]
            },
            options: {
        
                scales: {
        
                    yAxes: [{
                        ticks: {
                            fontFamily: "IRANSans",
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontFamily: "IRANSans",
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }]
                },
                legend: {
                    display: false,
                },
        
                title: {
                    fontFamily: "IRANSans",
                    display: true,
                    text: 'نمودار تراکنش ها از تاریخ تا تاریخ'
                }
        
            }
        });

        new Chart(document.getElementById("myChartLineInAccordion"), {
            type: 'line',
            data: {
                labels: stats.map(elem => { 

                    if(typeof elem.date === 'number')
                        return (elem.date + "").substr(0, 4) + "/" + (elem.date + "").substr(4, 2) + "/" + (elem.date + "").substr(6, 2);

                    return elem.date;
                }),
                datasets: [{
                    data: stats.map(elem => { return elem.count; }),
                    borderColor: "#3e95cd",
                    fill: false
                }, ]
            },
            options: {
        
                scales: {
        
                    yAxes: [{
                        ticks: {
                            fontFamily: "IRANSans",
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontFamily: "IRANSans",
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }]
                },
                legend: {
                    display: false,
                },
        
                title: {
                    fontFamily: "IRANSans",
                    display: true,
                    text: 'نمودار تراکنش ها از تاریخ تا تاریخ'
                }
        
            }
        });

    }

</script>
@stop