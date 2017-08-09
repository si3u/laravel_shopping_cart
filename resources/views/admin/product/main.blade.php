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
                                    <a href="{{route('admin/product/add_page')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered m-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Изображение</th>
                                        <th class="text-center">Артикул</th>
                                        <th class="text-center">Наименование</th>
                                        <th class="text-center">Категория</th>
                                        <th class="text-center">Добавлен</th>
                                        <th class="text-center">Отображение в категор.</th>
                                        <th class="text-center">Операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($page->products as $product)
                                    <tr>
                                        <th class="text-center">
                                            <img class="img-responsive img-thumbnail thumb-lg" src="/assets/images/products/{{$product->image}}">
                                        </th>
                                        <th>
                                            {{$product->vendor_code}}
                                        </th>
                                        <td>
                                            {{$product->name}}
                                        </td>
                                        <td>
                                            @foreach($product->categories as $category)
                                                <p>{{$category->name}}</p>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            {{$product->created_at}}
                                        </td>
                                        <td class="text-center">
                                            @if($product->status)
                                                Да
                                            @else
                                                Нет
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin/product/update_page', ['id' => $product->id])}}" class="btn btn-sm btn-primary">
                                                <i class="dripicons-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center">
                                    {{$page->products->render()}}
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
@endsection