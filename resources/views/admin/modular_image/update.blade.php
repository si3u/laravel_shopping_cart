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
                                    <a href="{{route('admin/modular_images')}}">
                                        <i class="dripicons-arrow-thin-left"></i> Ко всем модулям
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center text-custom font-13">
                                        <strong>Размеры модуля</strong>
                                    </p>
                                    <hr>
                                    <form id="form" action="{{route('size_modular_image/add')}}"
                                          class="form-horizontal" onclick="return false;">
                                        <input type="hidden" name="modular_id" value="{{$page->item->data->id}}">
                                        @include('admin.includes.alerts.error_ajax')
                                        <table class="table table-striped m-0">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Порядковый номер картины</th>
                                                <th class="text-center">Ширина</th>
                                                <th class="text-center">Высота</th>
                                                <th class="text-center">Операции</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr id="row_add">
                                                <td class="text-center">
                                                    <input id="number" name="number" class="form-control" type="text" placeholder="Номер картины">
                                                    <span class="help-block">
                                                        <small>Порядковый номер - указывается к картинам слева на право</small>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <input id="width" name="width" class="form-control" type="text" placeholder="Введите ширену">
                                                </td>
                                                <td>
                                                    <input id="height" name="height" class="form-control" type="text" placeholder="Введите высоту">
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-success" onclick="modularSize.add()">
                                                        <i class="dripicons-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @foreach($page->item->sizes as $item)
                                                <tr id="item_{{$item->id}}">
                                                    <td class="text-center">Картина {{$item->number}}</td>
                                                    <td class="text-center">{{$item->width}}</td>
                                                    <td class="text-center">{{$item->height}}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger" onclick="modularSize.delete({{$item->id}})">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center text-custom font-13">
                                        <strong>Модуль</strong>
                                    </p>
                                    <hr>
                                    <div class="thumbnail">
                                        <img src="/assets/images/modular/{{$page->item->data->preview_image}}" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/modularSize.js') !!}
@endsection