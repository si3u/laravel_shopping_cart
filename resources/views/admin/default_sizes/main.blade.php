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
                    <div class="card-box">
                        <form id="form_default_size_add"
                              nama="form_default_size_add"
                              action="{{route('admin/default_size/add')}}"
                              class="form-horizontal" onclick="return false;">
                            <table class="table table-bordered m-0">
                                <thead>
                                <tr>
                                    <th>Ширина</th>
                                    <th>Высота</th>
                                    <th>Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="row_add">
                                    <td>
                                        <input id="width" name="width" class="form-control" type="text" placeholder="Введите ширену">
                                    </td>
                                    <td>
                                        <input id="height" name="height" class="form-control" type="text" placeholder="Введите высоту">
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-block" onclick="defaultSize.add()">Добавить</button>
                                    </td>
                                </tr>
                                @foreach($page->size as $item)
                                    <tr id="item_{{$item->id}}">
                                        <td class="text-center">{{$item->width}}</td>
                                        <td class="text-center">{{$item->height}}</td>
                                        <td>
                                            <button class="btn btn-danger btn-block" onclick="defaultSize.delete({{$item->id}})">
                                                <i class="dripicons-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>

                        <div class="text-center">
                            {{$page->size->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    <script src="{{ asset('assets/admin/my_js_scripts/defaultSize.js')}}"></script>
@endsection
