@extends('admin.layouts.main')
@section('title')
    {{$page->title}}
@endsection
@section('content')
    {{ HTML::mailto('myemail@mail.com','Some person', ['id'=>'myEmail']) }}
    <div id="wrapper">
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')
    </div>
    <div class="content-page">
        <div class="content">
            <input type="hidden" id="item_id" value="null">

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
                                    <a href="{{route('admin/product/add_page')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card-box">
                            @if($page->route_name == 'admin/product/add_page')
                            <form id="form_work_on" action="javascript:void(0);" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <input type="hidden" name="item_id" value="">
                            @else
                            <form id="form_work_on" action="javascript:void(0);" class="form-horizontal" role="form">
                                <input type="hidden" name="item_id" value="{{$page->product->id}}">
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
                                    <?php $i = 0; ?>
                                    @foreach($page->active_lang as $item)
                                        @if ($i == 0)
                                            <div class="tab-pane active" id="{{$item->lang}}">
                                                <?php $path = 'admin.product.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @else
                                            <div class="tab-pane" id="{{$item->lang}}">
                                                <?php $path = 'admin.product.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3"><span class="text-danger">*</span> Артикул</label>
                                    <div class="col-md-9">
                                        <input name="vendor_code" id="vendor_code" class="form-control" placeholder="Введите артикул">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3"><span class="text-danger">*</span> Изображение</label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <button type="button" class="btn btn-block btn-primary btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Выбрать изображение</span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Выбрать другое изображение</span>
                                                    <input id="image" name="image" type="file" class="btn-block btn-primary" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3"><span class="text-danger">*</span> Ширина (мин./макс.)</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="min_width" id="min_width" class="form-control" placeholder="Минимальная ширина">
                                            </div>
                                            <div class="col-md-6">
                                                <input name="max_width" id="max_width" class="form-control" placeholder="Максимальная ширина">
                                            </div>
                                        </div>
                                        <span class="help-block">
                                            <small>Ширина указывается в см. и должна быть целочисленным значением</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3"><span class="text-danger">*</span> Высота (мин./макс.)</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="min_height" id="min_height" class="form-control" placeholder="Минимальная высота">
                                            </div>
                                            <div class="col-md-6">
                                                <input name="max_height" id="max_height" class="form-control" placeholder="Максимальная высота">
                                            </div>
                                        </div>
                                        <span class="help-block">
                                            <small>Высота указывается в см. и должна быть целочисленным значением</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3"><span class="text-danger">*</span> Категория</label>
                                    <div class="col-md-9">
                                        {!! $page->tree !!}
                                        <span class="help-block">
                                            <small>Если хотите добавить товар в несколько категорий: Зажмите Ctrl+ЛКМ</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="size" class="control-label col-md-3"><span class="text-danger">*</span> Размеры</label>
                                    <div class="col-md-9">
                                        @if(count($page->size) > 0)
                                            <select id="size" name="size[]" class="form-control" multiple>
                                                @foreach($page->size as $item)
                                                    <option value="{{$item->id}}">{{$item->width}}x{{$item->height}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <div class="alert alert-info alert-white alert-dismissible fade in" role="alert">
                                                Пока нет ни одного размера. <a href="{{route('admin/default_sizes')}}">Перейти</a> к созданию размеров
                                            </div>
                                        @endif
                                        <span class="help-block">
                                                <small>Зажмите Ctrl+ЛКМ и отметьте размеры которые доступны для этого товара</small>
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color" class="control-label col-md-3">Фильтр по цвету</label>
                                    <div class="col-md-9">
                                        @if(count($page->color) > 0)
                                            <select id="color" name="color[]" class="form-control" multiple>
                                                @foreach($page->color as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <div class="alert alert-info alert-white alert-dismissible fade in" role="alert">
                                                Пока нет ни одного цвета. <a href="{{route('admin/filter_colors')}}">Перейти</a> к созданию цветов
                                            </div>
                                        @endif
                                        <span class="help-block">
                                            <small>Зажмите Ctrl+ЛКМ и отметьте цвета по которым товар будет выводится применяя фильтр по цвету</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;" id="group_errors">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-9">
                                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                            <div class="text-left" id="errors_list">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-9">
                                        <p class="text-muted m-b-20 font-13">
                                            * - Отмечены обязательные для заполнения поля.
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <div class="pull-right">
                                            @if($page->route_name == 'admin/product/add_page')
                                                <button type="submit" id="btn_add" class="btn btn-success btn-lg">
                                                    Добавить
                                                </button>
                                                <button style="display: none;" id="btn_update" class="btn btn-success btn-lg" onclick="product.update()">
                                                    Обновить данные
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-lg" onclick="$('#modal_product_delete').modal('show');">
                                                    Удалить
                                                </button>
                                                <button id="btn_update" class="btn btn-success btn-lg" onclick="product.update()">
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
    </div>
    @if($page->route_name == 'admin/product/update_page')
        @include('admin.product.modal_delete')
    @endif
@endsection
@section('my_scripts')
    <script src="{{ asset('assets/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    {!! script_ts('/assets/admin/my_js_scripts/product.js') !!}
@endsection