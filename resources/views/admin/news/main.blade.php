@extends('admin.layouts.main')
@section('title')
    {{$page->title}}
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
                                @if($page->route_name == 'admin/news/search')
                                    <li>
                                        <a href="{{route('admin/news')}}">
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем новостям
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{route('news/add_page')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('admin.news.form_search')
                        <div class="card-box">
                            @include('admin.includes.alerts.success_alerts')
                            @include('admin.includes.alerts.error_alerts')
                            <table class="table table-striped m-0">
                                <thead>
                                <tr>
                                    <th class="text-left">Изображение</th>
                                    <th class="text-center">Наименование</th>
                                    <th class="text-center">Дата добавления</th>
                                    <th class="text-center">Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($page->news) > 0)
                                        @foreach($page->news as $news)
                                            <tr id="item_{{$news->id}}">
                                                <td>
                                                    @if($news->image_preview != null)
                                                        <img width="150" height="auto" class="img-responsive" src="/assets/images/news/{{$news->image_preview}}" alt="image">
                                                    @else
                                                        <img width="150" height="auto" class="img-responsive" src="/assets/images/default.png" alt="image">
                                                    @endif
                                                </td>
                                                <td>{{str_limit($news->topic, $limit = 100, $end = '...')}}</td>
                                                <td class="text-center">{{$news->created_at}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('news/update_page', ['id' => $news->id])}}" type="button" class="btn btn-primary waves-effect waves-light btn-sm">
                                                            <i class="dripicons-pencil"></i>
                                                        </a>
                                                        <button onclick="news.delete({{$news->id}});" class="btn btn-danger waves-effect waves-light btn-sm">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">
                                                <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                    По запросу новостей нет.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="text-center">
                                {!! $page->news->appends(request()->input())->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.news.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/news.js') !!}
@endsection