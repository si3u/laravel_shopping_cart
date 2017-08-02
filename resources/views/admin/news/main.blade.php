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
                        <div class="card-box">
                            <table class="table table-bordered m-0">
                                <thead>
                                <tr>
                                    <th class="text-center">Изображение</th>
                                    <th>Наименование</th>
                                    <th>Дата добавления</th>
                                    <th>Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($page->news as $news)
                                        <tr id="item_{{$news->id}}">
                                            <td>
                                                <img src="/assets/images/news/{{$news->image_preview}}" alt="image" class="img-responsive thumb-md">
                                            </td>
                                            <td>{{str_limit($news->topic, $limit = 100, $end = '...')}}</td>
                                            <td>{{$news->created_at}}</td>
                                            <td>
                                                <a href="{{route('news/update_page', ['id' => $news->id])}}" type="button" class="btn btn-primary waves-effect waves-light btn-sm">
                                                    <i class="dripicons-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="pull-right">
                                    {!! $page->news->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
    </div>
@endsection