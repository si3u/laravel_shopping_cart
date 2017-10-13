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
                                    <a href="{{route('admin/news/comments')}}">
                                        <i class="dripicons-arrow-thin-left"></i> Ко всем комментариям
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-7">
                                    <p class="text-center text-custom font-13">
                                        <strong>Комментарий</strong>
                                    </p>
                                    <hr>
                                    <form id="form_work_on" action="javascript:void(0);" class="form-horizontal">
                                        <input id="id" name="id" type="hidden" value="{{$page->comment->id}}">
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label">
                                                Имя автора
                                            </label>
                                            <div class="col-md-9">
                                                <input value="{{$page->comment->name}}" id="name" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-md-3 control-label">
                                                E-mail автора
                                            </label>
                                            <div class="col-md-9">
                                                <input value="{{$page->comment->email}}" id="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="col-md-3 control-label">
                                                Комментарий
                                            </label>
                                            <div class="col-md-9">
                                                <textarea id="message" name="message" rows="3" class="form-control">{{$page->comment->text}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="col-md-3 control-label">
                                                Статус
                                            </label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1"
                                                        @if($page->comment->check_status)
                                                            selected
                                                        @endif >Включен</option>
                                                    <option value="0"
                                                            @if(!$page->comment->check_status)
                                                                selected
                                                            @endif >Выключен</option>
                                                </select>
                                                <span class="help-block">
                                                    <small>
                                                        Выберите статус чтобы включить или выключить комментарий для вывода на странице товара.
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                        @include('admin.includes.alerts.error_ajax')
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">
                                            </label>
                                            <div class="col-md-9">
                                                <a type="button" onclick="$('#modal_news_comment_delete').modal('show');" class="btn btn-lg btn-danger">
                                                    Удалить
                                                </a>
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-lg btn-success">
                                                        Сохранить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-5">
                                    <p class="text-center text-custom font-13">
                                        <strong>Информация о новости</strong>
                                    </p>
                                    <hr>
                                    <div class="thumbnail">
                                        <img src="/assets/images/news/{{$page->comment->news_image}}" class="img-responsive">
                                        <div class="caption">
                                            <dl class="dl-horizontal">
                                                <dt>Наименование:</dt>
                                                <dd>{{$page->comment->news_topic}}</dd>
                                            </dl>
                                            <p class="text-right">
                                                <a target="_blank" href="{{route('news/update_page', ['id' => $page->comment->news_id])}}" class="btn btn-lg btn-primary waves-effect waves-light" role="button">
                                                    Открыть новость
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.news.comments.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/news_comment.js') !!}
@endsection
