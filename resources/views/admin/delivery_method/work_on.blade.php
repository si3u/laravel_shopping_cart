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
                                    <a href="{{route('delivery_methods/page_add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card-box">
                            @if($page->route_name == 'delivery_methods/page_add')
                            <form id="form" action="{{route('delivery_method/add')}}" method="POST" class="form-horizontal" role="form" onclick="return false;">
                                <input type="hidden" name="item_id" value="null">
                            @else
                            <form id="form" action="{{route('delivery_method/update')}}" method="POST" class="form-horizontal" role="form" onclick="return false;">
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
                                    <?php $i = 0; ?>
                                    @foreach($page->active_lang as $item)
                                        @if ($i == 0)
                                            <div class="tab-pane active" id="{{$item->lang}}">
                                                <?php $path = 'admin.delivery_method.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @else
                                            <div class="tab-pane" id="{{$item->lang}}">
                                                <?php $path = 'admin.delivery_method.form_'.$item->lang; ?>
                                                @include($path)
                                            </div>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                    <div class="form-group">
                                        <label for="payment_methods" class="col-md-3 control-label">
                                            <span class="text-danger">*</span>
                                            Доступные методы оплаты
                                        </label>
                                        <div class="col-md-9">
                                            @if(count($page->payment_methods)>0)
                                                <select id="payment_methods" name="payment_methods[]" class="form-control" multiple>
                                                    @if($page->route_name == 'delivery_methods/page_add')
                                                        @foreach($page->payment_methods as $payment_method)
                                                            <option value="{{$payment_method->id}}">
                                                                {{$payment_method->DataLocal->name}}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach($page->payment_methods as $payment_method)
                                                            <option value="{{$payment_method->id}}"
                                                                    @if (in_array($payment_method->id, $page->active_payment_methods))
                                                                    selected
                                                                    @endif >
                                                                {{$payment_method->DataLocal->name}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @else
                                                <div class="alert alert-info alert-white alert-dismissible" role="alert">
                                                    Нет ни одного метода оплаты. Перейдите по
                                                    <a href="{{route('payment_methods/add')}}">ссылке</a> чтобы добавить методы оплаты.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.error_ajax')
                                <div class="form-group">
                                    <label class="control-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <div class="pull-right">
                                            @if($page->route_name == 'delivery_methods/page_add')
                                                <button id="btn_add" class="btn btn-success btn-lg" onclick="deliveryMethod.add()">
                                                    Добавить
                                                </button>
                                                <button style="display: none;" id="btn_update" class="btn btn-success btn-lg" onclick="deliveryMethod.update()">
                                                    Обновить данные
                                                </button>
                                            @else
                                                <button class="btn btn-danger btn-lg" onclick="$('#modal_delivery_method_delete').modal('show');">
                                                    Удалить
                                                </button>
                                                <button id="btn_update" class="btn btn-success btn-lg" onclick="deliveryMethod.update()">
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
    @include('admin.delivery_method.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/deliveryMethod.js') !!}
@endsection