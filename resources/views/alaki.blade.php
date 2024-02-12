@extends('layouts.structure')

@section('header')
    @parent

    <link href="{{ asset('theme-assets/js/chartjs/chart.min.js') }}" />
    <script src="{{ asset('theme-assets/js/chartjs/chart.min.js') }}"></script>
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="flexCenter">
                    <canvas id="myChart" width="400" height="400"></canvas> 
                </div>
            </div>
        </div>
    </div>

    <script>
        // onclick="function(e){e.stopPropagaction()}"
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>


@stop
