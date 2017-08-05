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
                                    <a href="{{route('admin/modular_images/add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card-box">
                        @include('admin.includes.alerts.success_alerts')
                        <table class="table table-bordered m-0">
                            <thead>
                            <tr>
                                <th class="text-center">Модуль</th>
                                <th class="text-center">Добавлен</th>
                                <th class="text-center">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($page->modular) > 0)
                                @foreach($page->modular as $item)
                                    <tr id="item_{{$item->id}}">
                                        <td class="text-center">
                                            <img src="/assets/images/modular/{{$item->preview_image}}">
                                        </td>
                                        <td class="text-center">
                                            {{$item->created_at}}
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-block" onclick="modularImage.delete({{$item->id}})">
                                                <i class="dripicons-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                                            Модулей пока нет.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        <div class="text-center">
                            {{$page->modular->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.modular_image.modal_delete')
@endsection
@section('my_scripts')
    <script>
        var modularImage = {
            'delete': function (id) {
                $('#href_delete').attr('href', '/admin/modular_image/delete/'+id);
                $('#modal_modular_image_delete').modal('show');
            }
        };
    </script>
@endsection