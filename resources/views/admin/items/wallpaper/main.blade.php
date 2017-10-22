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
                                @if ($page->route_name == 'admin/wallpapers')
                                <li>
                                    <a href="{{ url()->previous() }}">
                                        <i class="dripicons-arrow-thin-left"></i> Назад
                                    </a>
                                </li>
                                @else
                                    <li>
                                        <a href="{{route('admin/wallpapers')}}">
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем фотообоям
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{route('admin/wallpaper/add_page')}}">
                                        <i class="mdi mdi-plus"></i> Добавить
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                @if ($page->route_name == 'admin/wallpapers' || $page->route_name == 'admin/wallpapers/search')
                    @include('admin.items.wallpaper.form_search')
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @include('admin.includes.alerts.error_alerts')
                                @include('admin.includes.alerts.success_alerts')
                                <form @if($page->route_name == 'admin/recommend_paintings')
                                      method="post"
                                      action="{{route('recommend_painting/delete')}}"
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
                                    @if (count($page->items) > 0)
                                        @foreach($page->items as $item)
                                            <tr id="item_{{$item->id}}">
                                                <th>
                                                    <div class="checkbox checkbox-primary checkbox-single">
                                                        <input type="checkbox" id="check_products" name="check_products[]" value="{{$item->id}}">
                                                        <label></label>
                                                    </div>
                                                </th>
                                                <th class="text-center">
                                                    <img style="height: auto; max-width: 50px;" class="img-responsive thumb-lg" src="/assets/images/wallpapers/{{$item->image}}">
                                                </th>
                                                <th class="text-center">
                                                    {{$item->vendor_code}}
                                                </th>
                                                <td class="text-left">
                                                    {{$item->name}}
                                                </td>
                                                <td>
                                                    @foreach($item->categories as $category)
                                                        <p>
                                                            <a href="{{route('admin/wallpapers/search', ['category[]' => $category->id])}}">
                                                                {{$category->name}}
                                                            </a>
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    {{$item->created_at}}
                                                </td>
                                                <td class="text-center">
                                                    @if($item->status)
                                                        Да
                                                    @else
                                                        Нет
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('admin/wallpaper/update_page', ['id' => $item->id])}}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="dripicons-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger"
                                                                onclick="wallpaper.delete({{$item->id}})">
                                                            <i class="dripicons-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="btn-group m-b-10">
                                                        <a href="{{route('comments/search', ['vendor_code' => $item->vendor_code])}}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="mdi mdi-comment-multiple-outline"></i>
                                                        </a>
                                                        <a href="{{route('reviews/search', ['vendor_code' => $item->vendor_code])}}"
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
                                                    Данных по запросу нет.
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                    @if (count($page->items) > 0)
                                        <div class="btn-group">
                                            @if($page->route_name == 'admin/recommend_paintings')
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
                                    @endif
                                </form>
                                <div class="text-center">
                                    {{$page->items->appends(request()->input())->render()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.items.wallpaper.modal_delete')
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/js/project/wallpaper.js') !!}
@endsection
