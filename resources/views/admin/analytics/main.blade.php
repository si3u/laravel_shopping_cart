@extends('admin.layouts.main')
@section('title')
    Аналитика
@endsection
@section('my_styles')
    {!! style_ts('/assets/admin/css/chartist.min.css') !!}
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
                            <h4 class="page-title">Аналитика</h4>
                            <ol class="breadcrumb p-0 m-0">

                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                    </div>
                </div>
                <div class="row">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title text-center"><b>Общее количество посетителей и просмотренных ими страниц</b></h4>
                        <p class="text-muted font-14 m-b-20">
                            <code class="text-danger">Красная</code> шкала - количество посетителей
                        </p>
                        <p class="text-muted font-14 m-b-20">
                            <code class="text-primary">Синяя</code> шкала - количество просмотренных ими страниц
                        </p>
                        <div class="ct-chart ct-perfect-fourth" id="total_visitors_and_page_views"></div>
                    </div>

                    <div class="card-box">
                        <h4 class="m-t-0 header-title text-center"><b>Последние 20 страниц просмотренные посетителями</b></h4>
                        <div id="body_most_visited_pages"></div>
                    </div>

                    <div class="card-box">
                        <h4 class="m-t-0 header-title text-center"><b>Топ браузеров</b></h4>
                        <p class="text-muted font-14 m-b-20">
                            С этих браузеров заходили к Вам на сайт.
                        </p>
                        <p class="text-muted font-14 m-b-20">
                            Количество посещений - Y. X - Наименование браузеров.
                        </p>
                        <div class="ct-chart ct-perfect-fourth" id="top_browser"></div>
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

            var dataLibels = [];
            var dataSeries = [];
            for (var i in data.top_browsers) {
                dataLibels.push(data.top_browsers[i].browser);
                dataSeries.push(data.top_browsers[i].sessions);
            }
            new Chartist.Bar('#top_browser', {
                labels: dataLibels,
                series: dataSeries
            }, {
                distributeSeries: true
            });

            var dataLibels = [];
            var dataVisitors = [];
            var dataPageViews = [];
            for (var i in data.total_visitors_and_page_views) {
                var date = new Date(Date.parse(data.total_visitors_and_page_views[i].date.date));
                dataLibels.push(date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear());
                dataVisitors.push(data.total_visitors_and_page_views[i].visitors);
                dataPageViews.push(data.total_visitors_and_page_views[i].pageViews);
            }
            new Chartist.Bar('#total_visitors_and_page_views', {
                labels: dataLibels,
                series: [dataVisitors, dataPageViews]
            }, {
                seriesBarDistance: 10,
                reverseData: true,
                horizontalBars: true,
                axisY: {
                    offset: 70
                }
            });

            if (data.most_visited_pages.length > 0) {
                $('#body_most_visited_pages').append('<table class="table table-striped m-0">\n' +
                    '                                        <thead>\n' +
                    '                                        <tr>\n' +
                    '                                            <th class="text-center">Заголовок</th>\n' +
                    '                                            <th class="text-center">URL</th>\n' +
                    '                                            <th class="text-center">Просмотров</th>\n' +
                    '                                        </tr>\n' +
                    '                                        </thead>\n' +
                    '                                        <tbody id="tbody_most_visited_pages">\n' +
                    '                                        </tbody>\n' +
                    '                                    </table>');


                for (var i in data.most_visited_pages) {
                    var tbody = $('#tbody_most_visited_pages');
                    tbody.append('<tr>\n' +
                        '              <th scope="row">'+data.most_visited_pages[i].pageTitle+'</th>\n' +
                        '              <td>'+data.most_visited_pages[i].url+'</td>\n' +
                        '              <td class="text-center">'+data.most_visited_pages[i].pageViews+'</td>\n' +
                        '         </tr>');
                }
            }
        });
    </script>
@endsection