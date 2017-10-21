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
                                @if($page->route_name == 'admin/orders/print_pictures/search')
                                    <li>
                                        <a href="{{route('admin/orders/print_pictures')}}">
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем заказам на печать
                                        </a>
                                    </li>
                                @endif
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('admin.orders.print.form_search')
                        <div class="card-box">
                            @include('admin.includes.alerts.success_alerts')
                            @include('admin.includes.alerts.error_alerts')
                            <table class="table table-striped m-0">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Телефон</th>
                                    <th class="text-center">Размер</th>
                                    <th class="text-center">Полотно</th>
                                    <th class="text-center">Скачать файл</th>
                                    <th class="text-center">Статус</th>
                                    <th class="text-center">Инфо.</th>
                                    <th class="text-center">Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($page->orders) > 0)
                                    @foreach($page->orders as $order)
                                        <tr>
                                            <td class="text-center">
                                                {{$order->id}}
                                                @if(!$order->read_status)
                                                    <span class="badge badge-danger pull-right">New</span>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                {{ $order->tel }}
                                            </td>
                                            <td class="text-center">
                                                {{ $order->width }}x{{ $order->height }}
                                            </td>
                                            <td class="text-center">
                                                @if ($order->canvas === 1)
                                                    Натуральное
                                                @else
                                                    Искуственное
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="text-info">{{ $order->file_exp }}</span>,
                                                <a href="{{ route('admin/download', ['model' => 'print_picture', 'file_name' => $order->file]) }}">Скачать</a>
                                            </td>
                                            <td class="text-center">
                                                @if ($order->processing_status == 0)
                                                    Ожидает
                                                @else
                                                    {{ $order->processing_name }}
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                Создан: {{ $order->created_at }}<br>
                                                С локализации:
                                                @if ($order->local == 1)
                                                    Русская
                                                @elseif ($order->local == 2)
                                                    Украинская
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group m-b-10">
                                                    <a href="{{ route('admin/order/print_picture/page_update', ['id' => $order->id]) }}" type="button" class="btn btn-primary waves-effect waves-light btn-sm">
                                                        <i class="dripicons-pencil"></i>
                                                    </a>
                                                    <button onclick="printPicture.delete({{$order->id}});" class="btn btn-danger waves-effect waves-light btn-sm">
                                                        <i class="dripicons-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                По запросу нет заказов.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                            <div class="text-center">
                                {{$page->orders->appends(request()->input())->render()}}
                            </div>
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
