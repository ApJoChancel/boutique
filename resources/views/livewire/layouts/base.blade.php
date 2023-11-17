<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title ?? config('app.name') }}</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        @vite('resources/css/app.css')

        <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
        @livewireStyles
        <script>
            function pieGraphique(idcanvas, labels, datas){
                const pieCanvas = document.getElementById(idcanvas);
                const pieChart = new Chart(pieCanvas, {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            labels: labels,
                            data: datas,
                            backgroundColor: [
                                'rgb(135, 206, 235)',
                                'rgb(255, 105, 97)',
                                'rgb(173, 255, 47)',
                                'rgb(255, 255, 153)',
                                'rgb(140, 96, 11)',
                                'rgb(122, 79, 52)',
                                'rgb(85, 123, 9)',
                                'rgb(10, 202, 78)',
                                'rgb(47, 180, 40)',
                                'rgb(32, 200, 89)',
                                'rgb(255, 250, 90)',
                            ],
                            hoverOffset: 40,
                            borderWidth: 1
                        }],
                    },
                });
            }

            function barGraphique(idcanvas, labels, datas){
                const barCanvas = document.getElementById(idcanvas);
                const barChart = new Chart(barCanvas, {
                    type: "bar",
                    data: {
                        labels: labels,
                        datasets: [{
                            labels: labels,
                            data: datas,
                            backgroundColor: [
                                'rgb(135, 206, 235)',
                                'rgb(255, 105, 97)',
                                'rgb(173, 255, 47)',
                                'rgb(255, 255, 153)'
                            ],
                        }
                    ]
                    },
                });
            }
        </script>

        <script type="text/javascript">
            function barChart(id, labels, datas){
                var dom = document.getElementById(id);
                var myChart = echarts.init(dom, null, {
                    renderer: 'canvas',
                    useDirtyRect: false
                });
                var app = {};
        
                var option;

                option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        },
                        formatter: function (params) {
                        var tar = params[0];
                            return tar.name + ' : ' + tar.value.toLocaleString('fr-FR');
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: labels
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: 'Montant',
                            type: 'bar',
                            stack: 'Total',
                            label: {
                                show: true,
                                position: 'inside'
                            },
                            data: datas
                        }
                    ]
                };

                if (option && typeof option === 'object') {
                    myChart.setOption(option);
                }

                window.addEventListener('resize', myChart.resize);
            }

            function pieChart(id, labels, datas){
                var dom = document.getElementById(id);
                var myChart = echarts.init(dom, null, {
                    renderer: 'canvas',
                    useDirtyRect: false
                });
                var app = {};
    
                var option;

                option = {
                    tooltip: {
                        trigger: 'item',
                        formatter: function (param) {
                            return param.name + ' : ' + param.value.toLocaleString('fr-FR') + ' (' + param.percent + '%)';
                        }
                    },
                    legend: {
                        data: labels
                    },
                    series: [
                        {
                            name: 'Option',
                            type: 'pie',
                            radius: ['45%', '60%'],
                            labelLine: {
                                length: 30
                            },
                            label: {
                                formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}: }{c}  {per|{d}%}  ',
                                backgroundColor: '#F6F8FC',
                                borderColor: '#8C8D8E',
                                borderWidth: 1,
                                borderRadius: 4,
                                rich: {
                                    a: {
                                        color: '#6E7079',
                                        lineHeight: 22,
                                        align: 'center'
                                    },
                                    hr: {
                                        borderColor: '#8C8D8E',
                                        width: '100%',
                                        borderWidth: 1,
                                        height: 0
                                    },
                                    b: {
                                        color: '#4C5058',
                                        fontSize: 14,
                                        fontWeight: 'bold',
                                        lineHeight: 33
                                    },
                                    per: {
                                        color: '#fff',
                                        backgroundColor: '#4C5058',
                                        padding: [3, 4],
                                        borderRadius: 4
                                    }
                                }
                            },
                            data: datas
                        }
                    ]
                };

                if (option && typeof option === 'object') {
                    myChart.setOption(option);
                }

                window.addEventListener('resize', myChart.resize);
            }

            function lineChart(id, totaux, recus, reductions, restes, legend, axis){
                var dom = document.getElementById(id);
                var myChart = echarts.init(dom, null, {
                    renderer: 'canvas',
                    useDirtyRect: false
                });
                var app = {};
    
                var option;

                option = {
                    title: {
                        text: 'Toutes les caisses'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: legend
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: axis
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        totaux, recus, restes, reductions
                    ]
                };

                if (option && typeof option === 'object') {
                myChart.setOption(option);
                }

                window.addEventListener('resize', myChart.resize);
            }
        </script>
    </head>
    <body  class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('livewire.layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            window.addEventListener('close-toast', event => {
                $('#toast').modal('hide');
            });
    
            window.addEventListener('close-toast-after-3-seconds', event => {
                setTimeout(function () {
                    document.getElementById('toast').style.display = 'none';
                }, 10000);
            });
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
        @livewireScripts
    </body>
</html>
