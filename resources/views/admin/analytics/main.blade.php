@extends('admin.layouts.main')
@section('title')
    Аналитика
@endsection
@section('my_styles')
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection
@section('content')
    <div id="wrapper">
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')
    </div>
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{$page->title}}</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <form action="{{route('admin/analytics')}}" method="get" class="form-inline">
                                    <div class="form-group m-r-10">
                                        <label for="period">Отчет </label>
                                        <div class="input-group">
                                            @if(isset($page->period))
                                                <select name="period" id="period" class="form-control">
                                                    <option @if($page->period === 'week') selected @endif value="week">за неделю</option>
                                                    <option @if($page->period === 'month') selected @endif value="month">за месяц</option>
                                                    <option @if($page->period === 'year') selected @endif value="year">за год</option>
                                                    <option @if($page->period === 'at_first') selected @endif value="at_first">с самого начала</option>
                                                </select>
                                            @else
                                                <select name="period" id="period" class="form-control">
                                                    <option selected value="week">за неделю</option>
                                                    <option value="month">за месяц</option>
                                                    <option value="year">за год</option>
                                                    <option value="at_first">с самого начала</option>
                                                </select>
                                            @endif
                                            <span class="input-group-btn">
                                                <button style="height: 38px;" class="btn btn-primary" type="submit" tabindex="-1">
                                                    Показать
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="card-box widget-box-two widget-two-custom">
                        <i class="mdi mdi-account-multiple widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-bold font-secondary text-overflow">
                                Сейчас на сайте
                            </p>
                            <h2 class="">
                                    <span data-plugin="counterup">
                                        {{$page->active_users}}
                                    </span>
                            </h2>
                            <p class="m-0">человек</p>
                        </div>
                    </div>

                    <div class="portlet">
                        <div class="portlet-heading bg-custom">
                            <h3 class="portlet-title">
                                Общее количество посетителей и просмотренных ими страниц
                            </h3>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse"
                                   data-parent="#total_visitors_and_page_views"
                                   href="#bg-default" class="" aria-expanded="true">
                                    <i class="mdi mdi-minus"
                                       data-toggle="tooltip" data-placement="top" title="Свернуть"
                                    ></i>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="bg-default" class="panel-collapse collapse in" aria-expanded="true" style="">
                            <div class="portlet-body">
                                <div id="total_visitors_and_page_views"></div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet">
                        <div class="portlet-heading bg-custom">
                            <h3 class="portlet-title">
                                Последние 20 страниц просмотренные посетителями
                            </h3>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse"
                                   data-parent="#body_most_visited_pages"
                                   href="#pb_most_visited_pages" class="" aria-expanded="true">
                                    <i class="mdi mdi-minus"
                                       data-toggle="tooltip" data-placement="top" title="Свернуть"
                                    ></i>
                                </a>
                            </div>
                            <div class="clearfix" style="height: 30px;"></div>
                        </div>
                        <div id="pb_most_visited_pages" class="panel-collapse collapse in" aria-expanded="true" style="">
                            <div class="portlet-body">
                                <div id="body_most_visited_pages"></div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet">
                        <div class="portlet-heading bg-custom">
                            <h3 class="portlet-title">
                                Страны с которых заходили на сайт
                            </h3>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse"
                                   data-parent="#user_countries"
                                   href="#pb_user_countries" class="" aria-expanded="true">
                                    <i class="mdi mdi-minus"
                                       data-toggle="tooltip" data-placement="top" title="Свернуть"
                                    ></i>
                                </a>
                            </div>
                            <div class="clearfix" style="height: 30px;"></div>
                        </div>
                        <div id="pb_user_countries" class="panel-collapse collapse in" aria-expanded="true" style="">
                            <div class="portlet-body">
                                <div id="draw_user_countries"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="portlet">
                        <div class="portlet-heading bg-custom">
                            <h3 class="portlet-title">
                                Топ браузеров
                            </h3>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse"
                                   data-parent="#top_browser"
                                   href="#pb_top_browser" class="" aria-expanded="true">
                                    <i class="mdi mdi-minus"
                                       data-toggle="tooltip" data-placement="top" title="Свернуть"
                                    ></i>
                                </a>
                            </div>
                            <div class="clearfix" style="height: 30px;"></div>
                        </div>
                        <div id="pb_top_browser" class="panel-collapse collapse in" aria-expanded="true" style="">
                            <div class="portlet-body">
                                <div id="draw_top_browsers"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet">
                        <div class="portlet-heading bg-custom">
                            <h3 class="portlet-title">
                                С этих устройств заходили к Вам на сайт
                            </h3>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse"
                                   data-parent="#user_devices"
                                   href="#pb_user_devices" class="" aria-expanded="true">
                                    <i class="mdi mdi-minus"
                                       data-toggle="tooltip" data-placement="top" title="Свернуть"
                                    ></i>
                                </a>
                            </div>
                            <div class="clearfix" style="height: 30px;"></div>
                        </div>
                        <div id="pb_user_devices" class="panel-collapse collapse in" aria-expanded="true" style="">
                            <div class="portlet-body">
                                <div id="draw_user_devices"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.includes.javascript')
@section('my_scripts')
    {!! script_ts('/assets/admin/js/chartist.min.js') !!}

    <script>
        $(document).ready(function () {
            var data = {!! json_encode($page) !!};

            google.charts.load('current', {'packages': ['line']});
            google.charts.setOnLoadCallback(drawTotalVisitorsAndPageViews);

            function drawTotalVisitorsAndPageViews() {
                var dataGoogle = new google.visualization.DataTable();
                dataGoogle.addColumn('string', 'дата');
                dataGoogle.addColumn('number', 'Посетителей');
                dataGoogle.addColumn('number', 'Просмотренных ими страниц');
                var dataChart = [];
                for (var i in data.total_visitors_and_page_views) {
                    var date = new Date(Date.parse(data.total_visitors_and_page_views[i].date.date));
                    dataChart.push([
                        date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear(),
                        data.total_visitors_and_page_views[i].visitors,
                        data.total_visitors_and_page_views[i].pageViews
                    ]);
                }
                dataGoogle.addRows(dataChart);
                var options = {
                    height: 600
                };
                var chart = new google.charts.Line(document.getElementById('total_visitors_and_page_views'));
                chart.draw(dataGoogle, google.charts.Line.convertOptions(options));
            }

            google.charts.load('current', {'packages': ['bar']});
            google.charts.setOnLoadCallback(drawMostVisitedPages);

            function drawMostVisitedPages() {
                var dataChart = [];
                dataChart.push(['Страницы', 'Количество посетителей']);
                for (var i in data.most_visited_pages) {
                    dataChart.push([
                        data.most_visited_pages[i].pageTitle + '(' + data.most_visited_pages[i].url + ')',
                        data.most_visited_pages[i].pageViews
                    ]);
                }
                var dataGoogle = new google.visualization.arrayToDataTable(dataChart);
                var options = {
                    height: 600,
                    legend: {position: 'none'},
                    bars: 'horizontal', // Required for Material Bar Charts.
                    axes: {
                        x: {
                            0: {side: 'top', label: 'Количество посещений'} // Top x-axis.
                        }
                    },
                    bar: {groupWidth: "100%"}
                };
                var chart = new google.charts.Bar(document.getElementById('body_most_visited_pages'));
                chart.draw(dataGoogle, options);
            }

            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChartTopBrowsers);
            google.charts.setOnLoadCallback(drawUserDevices);
            google.charts.setOnLoadCallback(drawUserCountries);

            function drawChartTopBrowsers() {
                var dataGoogle = new google.visualization.DataTable();
                dataGoogle.addColumn('string', 'Topping');
                dataGoogle.addColumn('number', 'Slices');
                var dataChars = [];
                for (var i in data.top_browsers) {
                    dataChars.push([
                        data.top_browsers[i].browser,
                        data.top_browsers[i].sessions
                    ]);
                }
                dataGoogle.addRows(dataChars);
                var options = {
                    'title': 'С этих браузеров заходили к Вам на сайт',
                    'height': 400
                };
                var chart = new google.visualization.PieChart(document.getElementById('draw_top_browsers'));
                chart.draw(dataGoogle, options);
            }
            function drawUserDevices() {
                var dataGoogle = new google.visualization.DataTable();
                dataGoogle.addColumn('string', 'Topping');
                dataGoogle.addColumn('string', 'Slices');
                var dataChars = [];
                for (var i in data.user_devices) {
                    dataChars.push([
                        data.user_devices[i][0],
                        data.user_devices[i][1]
                    ]);
                }
                dataGoogle.addRows(dataChars);
                var options = {
                    'height': 400
                };
                var chart = new google.visualization.PieChart(document.getElementById('draw_user_devices'));
                chart.draw(dataGoogle, options);
            }
            function drawUserCountries() {
                var dataGoogle = new google.visualization.DataTable();
                dataGoogle.addColumn('string', 'Topping');
                dataGoogle.addColumn('string', 'Slices');
                var dataChars = [];
                for (var i in data.user_countries) {
                    dataChars.push([
                        data.user_countries[i][0],
                        data.user_countries[i][1]
                    ]);
                }
                dataGoogle.addRows(dataChars);
                var options = {
                    'height': 400
                };
                var chart = new google.visualization.PieChart(document.getElementById('draw_user_countries'));
                chart.draw(dataGoogle, options);
            }
        });
    </script>
@endsection