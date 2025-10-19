<!DOCTYPE>
<html>
    <head>
        <title>Audiometri Chart</title>
        <style>
            .chart {
                width: 800px;
                height: 275px;
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
        <audiometri>
            <div id="left-audiometri" class="chart"></div>
            <div id="right-audiometri" class="chart"></div>
        </audiometri>
        <script src="{{ asset('js/libs/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/plugin/highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('js/plugin/highcharts/highcharts-3d.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('#left-audiometri').highcharts({
                    chart: {
                        type: 'areaspline',
                        backgroundColor: '#fff',
                        animation: false
                    },
                    legend: {
                        enabled: true,
                        floating: true,
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        itemMarginBottom: 5,
                        symbolHeight: 10,
                        symbolWidth: 10
                    },
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0,
                            lineWidth: 2,
                            marker: {
                                //enabled: false,
                                lineWidth: 4,
                                symbol: 'circle'
                            },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: '400'
                                },
                                y: -5
                            }
                        },
                        series: {
                            animation: false
                        }
                    },
                    xAxis: {
                        categories: [{{$categories}}],
                        lineColor: '#000',
                        lineWidth: 1,
                        gridLineWidth: 0.5,
                        gridLineDashStyle: 'longdash',
                        title: {
                            text: 'Frekuensi',
                            style: {
                                color: '#000',
                                fontSize: '14px',
                                fontWeight: '700'
                            },
                            y: 10
                        },
                        labels: {
                            style: {
                                color: '#000',
                                fontSize: '13px',
                                fontWeight: '400'
                            }
                        }
                    },
                    yAxis: {
                        lineColor: '#000',
                        lineWidth: 1,
                        gridLineWidth: 0.5,
                        gridLineDashStyle: 'longdash',
                        tickWidth: 1,
                        tickLength: 10,
                        tickColor: 'black',
                        title: {
                            text: 'Hasil',
                            style: {
                                color: '#000',
                                fontSize: '14px',
                                fontWeight: '700'
                            },
                            x: 0
                        },
                        labels: {
                            style: {
                                color: '#000',
                                fontSize: '13px',
                                fontWeight: '400'
                            }
                        }
                    },
                    title: {
                        text: 'Grafik Audiometri',
                        style: {
                            color: '#000',
                            fontSize: '14px',
                            fontWeight: '700'
                        }
                    },
                    credits: false,
                    series: [
                        {
                            name: 'Kiri',
                            color: '#0000ff',
                            marker: {
                                lineColor: '#0000ff'
                            },
                            data: [{{$leftAudio}}]
                        },
                        {
                            name: 'Kanan',
                            color: '#ff0000',
                            marker: {
                                lineColor: '#ff0000'
                            },
                            data: [{{$rightAudio}}]
                        }
                    ]
                });
            });
        </script>
    </body>
</html>
