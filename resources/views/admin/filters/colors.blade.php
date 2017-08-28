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
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('admin.includes.alerts.error_ajax')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-box">
                                <h4 class="m-t-0 m-b-30 header-title">Добавление цвета</h4>
                                <form id="form_add_color" action="javascript:;" role="form">
                                    <div class="form-group">
                                        <label for="color">Выберите цвет</label>
                                        <input type="color" class="form-control" id="hex" name="hex">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Наименование</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите наименование">
                                    </div>
                                    <div class="form-group" style="display: none;" id="group_errors_add_color">
                                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                            <div class="text-left" id="errors_list_add_color">

                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="filterColor.add()" class="btn btn-success waves-effect waves-light">Добавить</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-box">
                                <h4 class="m-t-0 m-b-30 header-title">Имеющиеся</h4>
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Наименование</th>
                                        <th class="text-center">Цвет</th>
                                        <th class="text-center">Операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($page->colors)>0)
                                        @foreach($page->colors as $item)
                                            <tr id="item_{{$item->id}}">
                                                <td class="text-left">{{$item->name}}</td>
                                                <td class="text-center text-muted" bgcolor="{{$item->hex}}">{{$item->hex}}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm btn-block" onclick="filterColor.delete({{$item->id}})">
                                                        <i class="dripicons-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="3">
                                                <div id="alert_empty" class="alert alert-info alert-dismissible fade in" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    Данных нет
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    {{$page->colors->render()}}
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
    {!! script_ts('/assets/admin/js/project/filterColor.js') !!}
@endsection
