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
                                    <a href="{{route('admin/categories/add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card-box">
                            @if($page->route_name == 'admin/categories/add')
                            <form id="form_add" action="{{route('admin/category/add')}}" class="form-horizontal" role="form" onclick="return false;">
                                <input type="hidden" name="item_id" value="null">
                            @else
                            <form id="form_add" action="{{route('category/update')}}" class="form-horizontal" role="form" onclick="return false;">
                                <input type="hidden" name="item_id" value="{{$page->category->id}}">
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
                                                <?php $path = 'admin.categories.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @else
                                            <div class="tab-pane" id="{{$item->lang}}">
                                                <?php $path = 'admin.categories.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <div class="form-group" style="display: none;" id="group_errors">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                        <div class="text-left" id="errors_list">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <div class="pull-right">
                                            @if($page->route_name == 'admin/categories/add')
                                                <button id="btn_add" class="btn btn-success btn-lg" onclick="category.add()">
                                                    Добавить
                                                </button>
                                                <button style="display: none;" id="btn_update" class="btn btn-success btn-lg" onclick="category.update()">
                                                    Обновить данные
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-lg" onclick="$('#modal_category_delete').modal('show');">
                                                    Удалить
                                                </button>
                                                <button id="btn_update" class="btn btn-success btn-lg" onclick="category.update()">
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
    @if($page->route_name == 'categories/update')
        @include('admin.categories.modal_delete')
    @endif
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/category.js') !!}
@endsection