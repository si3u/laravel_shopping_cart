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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-sub-title text-muted">
                                <i class="dripicons-paperclip"></i> - Обозначается статус который используется при получении заказа.
                                Этот статус будет отправляться на E-mail заказчика.
                            </p>
                        </div>
                        <div class="panel-body">
                            <form id="form"
                                  action="javascript:void(0);"
                                  class="form-horizontal">
                                @include('admin.includes.alerts.error_ajax')
                                @include('admin.includes.alerts.error_alerts')
                                @include('admin.includes.alerts.success_alerts')
                                @include('admin.includes.alerts.error_alert')
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Наименование статуса</th>
                                        <th class="text-center">Операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id="row_add">
                                        <td class="text-center">
                                            <input id="name" name="name" class="form-control" type="text" placeholder="Введите наименование">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-success" onclick="orderStatus.add()">
                                                <i class="dripicons-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach($page->statuses as $item)
                                        <tr>
                                            <td class="text-center">
                                                @if($item->upon_receipt)
                                                    <i class="dripicons-paperclip"></i>
                                                @endif
                                                {{$item->name}}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group m-b-10">
                                                    <a href="{{route('setting/order_status/upon_receipt', ['id'=>$item->id])}}" class="btn btn-custom">
                                                        <i class="dripicons-paperclip"></i>
                                                    </a>
                                                    <a href="{{route('setting/order_status/delete', ['id' => $item->id])}}" class="btn btn-danger">
                                                        <i class="dripicons-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>

                            <div class="text-center">
                                {{$page->statuses->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/settingOrderStatus.js') !!}
@endsection
