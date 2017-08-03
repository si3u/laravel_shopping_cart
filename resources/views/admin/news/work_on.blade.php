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
                                    <a href="{{ url()->previous() }}">
                                        <i class="dripicons-arrow-thin-left"></i> Назад
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('news/add_page')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-box">
                        @if($page->route_name == 'news/add_page')
                        <form id="form_work_on" action="javascript:;" class="form-horizontal" role="form">
                            <input type="hidden" name="item_id" value="null">
                        @else
                        <form id="form_work_on" action="javascript:;" class="form-horizontal" role="form">
                            <input type="hidden" name="item_id" value="{{$page->item_id}}">
                        @endif
                            <ul class="nav nav-tabs tabs-bordered nav-justified">
                                <?php $i = 0; ?>
                                @foreach($page->active_lang as $item)
                                    @if ($i == 0)
                                        <li class="active">
                                            <a href="#{{$item->lang}}" data-toggle="tab" aria-expanded="false">
                                                <span class="visible-xs">{{$item->name}}</span>
                                                <span class="hidden-xs">{{$item->name}}</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="">
                                            <a href="#{{$item->lang}}" data-toggle="tab" aria-expanded="false">
                                                <span class="visible-xs">{{$item->name}}</span>
                                                <span class="hidden-xs">{{$item->name}}</span>
                                            </a>
                                        </li>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @if ($page->route_name == 'news/add_page')
                                <div class="form-group"
                                     id="group_now_image"
                                     style="display: none;">
                                    <label class="control-label col-md-3">Текущее изображение</label>
                                    <div class="col-md-9">
                                        <img src="" id="now_image" alt="image" class="img-responsive">
                                    </div>
                                </div>
                                @else
                                    @if ($page->news->image_preview != null)
                                        <div class="form-group" id="group_now_image">
                                            <label class="control-label col-md-3">Текущее изображение</label>
                                            <div class="col-md-9">
                                                <img src="/assets/images/news/{{$page->news->image_preview}}" id="now_image" alt="image" class="img-responsive">
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group" id="group_now_image">
                                            <label class="control-label col-md-3">Текущее изображение</label>
                                            <div class="col-md-9">
                                                <img src="" id="now_image" alt="image" class="img-responsive">
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group">
                                    <label class="control-label col-md-3">Изображение</label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <button type="button" class="btn btn-default btn-file">
                                                    @if ($page->route_name == 'news/add_page')
                                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Выбрать изображение</span>
                                                    @else
                                                        @if ($page->news->image_preview == null)
                                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Выбрать изображение</span>
                                                        @else
                                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Выбрать новое изображение</span>
                                                        @endif
                                                    @endif
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Выбрать другое изображение</span>
                                                    <input id="image" name="image" type="file" class="btn-default" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i = 0; ?>
                                @foreach($page->active_lang as $item)
                                    @if ($i == 0)
                                        <div class="tab-pane active" id="{{$item->lang}}">
                                            <?php $path = 'admin.news.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @else
                                        <div class="tab-pane" id="{{$item->lang}}">
                                            <?php $path = 'admin.news.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-9">
                                        <p class="text-muted m-b-20 font-13">
                                            * - Отмечены обязательные для заполнения поля.
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;" id="group_errors">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <div class="text-left" id="errors_list">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9">
                                    <div class="pull-right">
                                        @if($page->route_name == 'news/add_page')
                                            <button id="btn_add" class="btn btn-success btn-lg" onclick="news.add()">
                                                Добавить
                                            </button>
                                            <button style="display: none;" id="btn_update" class="btn btn-success btn-lg" onclick="news.update()">
                                                Обновить данные
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-lg" onclick="$('#modal_news_delete').modal('show');">
                                                Удалить
                                            </button>
                                            <button id="btn_update" class="btn btn-success btn-lg" onclick="news.update()">
                                                Обновить данные
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    <script src="{{ asset('assets/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    {!! script_ts('/assets/admin/my_js_scripts/news.js') !!}
@endsection