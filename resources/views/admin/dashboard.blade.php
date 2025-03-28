@extends('layouts.master_admin')

@section('content')
    <style>
        #dashboard-chart {
            padding: 15px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            min-height: 400px;
            margin-bottom: 20px;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div id="dashboard-chart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Nhúng thư viện jQuery và ApexCharts --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(document).ready(function() {
            var dataSeries = [{
                    date: "2024-03-01",
                    value: 50000
                },
                {
                    date: "2024-03-02",
                    value: 60000
                },
                {
                    date: "2024-03-03",
                    value: 40000
                },
                {
                    date: "2024-03-04",
                    value: 70000
                },
                {
                    date: "2024-03-05",
                    value: 80000
                },
                {
                    date: "2024-03-06",
                    value: 65000
                },
                {
                    date: "2024-03-07",
                    value: 75000
                },
            ];

            var dates = dataSeries.map(item => [new Date(item.date).getTime(), item.value]);

            var options = {
                chart: {
                    type: "area",
                    height: 400,
                    fontFamily: "Arial, sans-serif",
                    zoom: {
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: "Doanh thu",
                    data: dates
                }],
                markers: {
                    size: 4
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100]
                    }
                },
                yaxis: {
                    title: {
                        text: "Doanh thu (VNĐ)"
                    }
                },
                xaxis: {
                    type: "datetime"
                },
                tooltip: {
                    x: {
                        format: "dd/MM/yyyy"
                    },
                    y: {
                        formatter: val => val.toLocaleString() + " VNĐ"
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#dashboard-chart"), options);
            chart.render();
        });
    </script>
@endsection
