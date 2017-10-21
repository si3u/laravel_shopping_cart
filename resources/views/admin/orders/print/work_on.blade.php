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
                                    <a href="{{route('admin/orders/print_pictures')}}">
                                        <i class="dripicons-arrow-thin-left"></i> Ко всем заказам на печать
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="card-box">
                            <p class="text-center text-custom font-13">
                                <strong>Заказ ID {{ $page->order->id }}</strong>
                            </p>
                            <hr>
                            <form id="form_work_on" action="javascript:void(0);" class="form-horizontal">
                                <input id="id" name="id" type="hidden" value="{{$page->order->id}}">
                                <div class="form-group">
                                    <label for="tel" class="col-md-3 control-label">
                                        Телефон
                                    </label>
                                    <div class="col-md-9">
                                        <input value="{{ $page->order->tel }}" id="tel" name="tel" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="width" class="col-md-3 control-label">
                                        Ширина
                                    </label>
                                    <div class="col-md-9">
                                        <input value="{{ $page->order->width }}" id="width" name="width" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="height" class="col-md-3 control-label">
                                        Высота
                                    </label>
                                    <div class="col-md-9">
                                        <input value="{{ $page->order->height }}" id="height" name="height" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="height" class="col-md-3 control-label">
                                        Прикрепленный файл
                                    </label>
                                    <div class="col-md-9">
                                        {{ $page->order->file_exp }},
                                        <a href="{{ route('admin/download', ['model' => 'print_picture', 'file_name' => $page->order->file]) }}">Скачать</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="canvas" class="col-md-3 control-label">
                                        Полотно
                                    </label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="canvas">
                                            <option value="0" @if ($page->order->canvas === 0) selected @endif>Искуственное</option>
                                            <option value="1" @if ($page->order->canvas === 1) selected @endif>Натуральное</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="processing_statuses" class="col-md-3 control-label">
                                        Статус
                                    </label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="processing_status">
                                            @foreach ($page->processing_statuses as $status)
                                                @if ($status->id === $page->order->processing_status)
                                                    <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                                @else
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="help-block">
                                            <small>
                                                Вы можете изменить статус заказа и искать заказы с учетом статуса.
                                            </small>
                                        </span>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.error_ajax')
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                    </label>
                                    <div class="col-md-9">
                                        <div class="pull-right">
                                            <button onclick="$('#modal_order_print_picture_delete').modal('show');" class="btn btn-lg btn-danger">
                                                Удалить
                                            </button>
                                            <button type="submit" class="btn btn-lg btn-success">
                                                Сохранить
                                            </button>
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
    @include('admin.orders.print.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/printPicture.js') !!}
@endsection
