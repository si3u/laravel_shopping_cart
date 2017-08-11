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
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем комментариям
                                        </a>
                                    </li>
                                @endif
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('admin.comments.form_search')
                        <div class="card-box">
                            @include('admin.includes.alerts.success_alerts')
                            @include('admin.includes.alerts.error_alerts')
                            <table class="table table-bordered m-0">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Товар</th>
                                    <th class="text-center">Автор</th>
                                    <th class="text-center">E-mail автора</th>
                                    <th class="text-center">Статус</th>
                                    <th class="text-center">Дата добавления</th>
                                    <th class="text-center">Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($page->comments) > 0)
                                    @foreach($page->comments as $comment)
                                        <tr>
                                            <td class="text-center">
                                                {{$comment->id}}
                                                @if(!$comment->read_status)
                                                    <span class="badge badge-danger pull-right">New</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a target="_blank" href="{{route('admin/product/update_page', ['id' => $comment->product_id])}}">
                                                    {{$comment->product_name}}
                                                </a>
                                            </td>
                                            <td class="text-center">{{$comment->name}}</td>
                                            <td class="text-center">{{$comment->email}}</td>
                                            <td class="text-center">
                                                @if($comment->check_status)
                                                    Включен
                                                @else
                                                    Выключен
                                                @endif
                                            </td>
                                            <td class="text-center">{{$comment->created_at}}</td>
                                            <td class="text-center">
                                                <a href="{{route('comment/page_update', ['id' => $comment->id])}}" type="button" class="btn btn-primary waves-effect waves-light btn-sm">
                                                    <i class="dripicons-pencil"></i>
                                                </a>
                                                <button onclick="comment.delete({{$comment->id}});" class="btn btn-danger waves-effect waves-light btn-sm">
                                                    <i class="dripicons-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                По запросу нет комментариев.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                            <div class="text-center">
                                {{$page->comments->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.comments.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/comment.js') !!}
@endsection