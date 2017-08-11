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
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card-box">
                        <form id="form_work_on" action="{{route('prices/update')}}" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                    <span class="text-danger">*</span> Цена за натуральный холст
                                </label>
                                <div class="col-md-9">
                                    <input @if(isset($page->data->natural_canvas))
                                           value="{{$page->data->natural_canvas}}"
                                           @else
                                           value="{{ old('natural_canvas') }}"
                                           @endif id="natural_canvas" name="natural_canvas" placeholder="Введите цену натуральный холст" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">
                                    <span class="text-danger">*</span> Цена за исскуственный холст
                                </label>
                                <div class="col-md-9">
                                    <input @if(isset($page->data->artificial_canvas))
                                           value="{{$page->data->artificial_canvas}}"
                                           @else
                                           value="{{ old('artificial_canvas') }}"
                                           @endif id="artificial_canvas" name="artificial_canvas" placeholder="Введите цену за исскуственный холст" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">
                                    <span class="text-danger">*</span> Цена за погонный метр
                                </label>
                                <div class="col-md-9">
                                    <input @if(isset($page->data->running_meter))
                                           value="{{$page->data->running_meter}}"
                                           @else
                                           value="{{ old('running_meter') }}"
                                           @endif id="running_meter" name="running_meter" placeholder="Введите цену за погонный метр" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">
                                    <span class="text-danger">*</span> Цена за работу
                                </label>
                                <div class="col-md-9">
                                    <input @if(isset($page->data->for_work))
                                           value="{{$page->data->for_work}}"
                                           @else
                                           value="{{ old('for_work') }}"
                                           @endif id="for_work" name="for_work" placeholder="Введите цену за работу" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-9">
                                    <span class="help-block">
                                        <small>
                                            * - обязательные поля для заполнения.
                                        </small>
                                    </span>
                                    <span class="help-block">
                                        <small>
                                            Цену можно указать как целочисленное значение так и число с плавающей точкой.
                                        </small>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-9">
                                    @include('admin.includes.alerts.error_alerts')
                                    @include('admin.includes.alerts.success_alerts')
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-9">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-lg btn-success">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection