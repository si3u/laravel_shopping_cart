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
                                @if ($page->route_name == 'admin/products')
                                <li>
                                    <a href="{{ url()->previous() }}">
                                        <i class="dripicons-arrow-thin-left"></i> Назад
                                    </a>
                                </li>
                                @else
                                    <li>
                                        <a href="{{route('admin/products')}}">
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем товарам
                                        </a>
                                    </li>
                                @endif
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
                @if ($page->route_name == 'admin/products' || $page->route_name == 'admin/product/search')
                    @include('admin.product.form_search')
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @include('admin.includes.alerts.error_alerts')
                                @include('admin.includes.alerts.success_alerts')
                                <form @if($page->route_name == 'admin/recommend_products')
                                      method="post"
                                      action="{{route('recommend_products/delete')}}"
                                      @else
                                      action="javascript:void(0);"
                                      @endif
                                      id="form_check">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="text-left">Артикул</th>
                                        <th class="text-left">Наименование</th>
                                        <th class="text-center">Категории</th>
                                        <th class="text-center">Добавлен</th>
                                        <th class="text-center">Отображение в категор.</th>
                                        <th class="text-center">Операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($page->products) > 0)
                                        @foreach($page->products as $product)
                                            <tr id="item_{{$product->id}}">
                                                <th>
                                                    <div class="checkbox checkbox-primary checkbox-single">
                                                        <input type="checkbox" id="check_products" name="check_products[]" value="{{$product->id}}">
                                                        <label></label>
                                                    </div>
                                                </th>
                                                <th class="text-center">
                                                    <img class="img-responsive thumb-lg" src="/assets/images/products/{{$product->image}}">
                                                </th>
                                                <th class="text-center">
                                                    {{$product->vendor_code}}
                                                </th>
                                                <td class="text-left">
                                                    {{$product->name}}
                                                </td>
                                                <td>
                                                    @foreach($product->categories as $category)
                                                        <p>
                                                            <a href="{{route('admin/product/search', ['category[]' => $category->id])}}">
                                                                {{$category->name}}
                                                            </a>
                                                        </p>
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
                                                <td class="text-center">
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('admin/product/update_page', ['id' => $product->id])}}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="dripicons-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger"
                                                                onclick="product.delete({{$product->id}})">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('comments/search', ['vendor_code' => $product->vendor_code])}}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="mdi mdi-comment-multiple-outline"></i>
                                                        </a>
                                                        <a href="{{route('reviews/search', ['vendor_code' => $product->vendor_code])}}"
                                                           class="btn btn-sm btn-custom">
                                                            <i class="mdi mdi-comment-processing-outline"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">
                                                <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                    Товаров по запросу нет.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                    <div class="btn-group">
                                        @if($page->route_name == 'admin/recommend_products')
                                            {!!csrf_field()!!}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Выбранные удалить с Рекомендуемых товары">
                                                <i class="dripicons-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Выбранные в Рекомендуемые товары"
                                                    onclick="checkProducts(1)">
                                                <i class="mdi mdi-star"></i>
                                            </button>
                                        @endif
                                    </div>
                                </form>
                                <div class="text-center">
                                    {{$page->products->appends(request()->input())->render()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.product.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/product.js') !!}
@endsection