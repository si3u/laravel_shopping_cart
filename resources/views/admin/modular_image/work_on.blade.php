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
                                    <a href="{{route('admin/modular_images/add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="panel-sub-title text-muted">
                                    После добавление перейдите в <a href="{{route('admin/modular_images')}}">список всех модулей</a>
                                    где можно будет перейти к редактированию  модуля и добавлению в него размеров картин на нем.
                                    Эти размеры используются чтобы при изменении размера заказываемого модуля высчитывались пропорциональные размеры картин на нем.
                                </p>
                            </div>
                            <div class="panel-body">
                                <form method="post" class="dropzone" name="add_modular_images" id="add_modular_images" action="{{route('admin/modular_image/add')}}">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                        <div class="card-box">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    <script src="{{ asset('assets/admin/my_js_scripts/dropzone.js') }}"></script>
    {!! script_ts('/assets/admin/my_js_scripts/modularImage.js') !!}
@endsection