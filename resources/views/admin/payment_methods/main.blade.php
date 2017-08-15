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
                                    <a href="{{route('payment_methods/add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-sub-title text-muted">

                            </p>
                        </div>
                        <div class="panel-body">
                            @include('admin.includes.alerts.error_alert')
                            @include('admin.includes.alerts.success_alerts')
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Наименование метода</th>
                                        <th class="text-center">Операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($page->payment_methods) > 0)
                                        @foreach($page->payment_methods as $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{$item->DataLocal->name}}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('payment_methods/update', ['id'=>$item->id])}}" class="btn btn-primary">
                                                            <i class="dripicons-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-danger" onclick="paymentMethod.delete({{$item->id}});">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                <div class="alert alert-info" role="alert">
                                                    Пока методов оплаты нет. Перейдите по ссылке "Добавить" чтобы добавить методы оплаты.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            <div class="text-center">
                                {{$page->payment_methods->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.payment_methods.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/paymentMethod.js') !!}
@endsection
