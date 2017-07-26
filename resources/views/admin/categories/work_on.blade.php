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
                                    <a href="{{route('admin/categories/add')}}">
                                        <i class="mdi mdi-plus"></i> Добавить еще
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-20">
                                        <form id="form_add" action="{{route('admin/category/add')}}" class="form-horizontal" role="form" onclick="return false;">
                                            @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif

                                            @if ($page->route_name == 'admin/categories/add')
                                                <input value="null" type="hidden" id="item_id">
                                            @endif

                                            @if ($page->route_name == 'admin/categories/update')
                                                <input value="{{$page->item_id}}" type="hidden" id="item_id">
                                            @endif

                                            <div class="form-group">
                                                <label class="col-md-2 control-label"><span class="text-danger">*</span> Наименование</label>
                                                <div class="col-md-10">
                                                    <input id="name" name="name" value="{{ old('name') }}" type="text" class="form-control" placeholder="Введите наименование">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label"><span class="text-danger">*</span> Порядок сортировки</label>
                                                <div class="col-md-10">
                                                    <input id="sorting_order" name="sorting_order" value="{{ old('sorting_order') }}" type="text" class="form-control" placeholder="Порядок сортировки">
                                                    <span class="help-block">
                                                        <small>Целочисленное значение. По этому значению сортируются категории.</small>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Описание</label>
                                                <div class="col-md-10">
                                                    <div id="description" name="description" class="summernote">{{ old('description') }}</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label"><span class="text-danger">*</span> Выберите родительскую категорию</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" id="parent_id" name="parent_id" value="{{ old('parent_id') }}">
                                                        <option value="">Не определено</option>
                                                    </select>
                                                    <span class="help-block">
                                                        <small>Не определено - если хотите чтобы это была родительская категория</small>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета-тег Title</label>
                                                <div class="col-md-10">
                                                    <input id="meta_title" name="meta_title" value="{{ old('meta_title') }}" type="text" class="form-control" placeholder="Мета-тег Title">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета-тег Description</label>
                                                <div class="col-md-10">
                                                    <textarea id="meta_description" name="meta_description" rows="5" type="text" class="form-control" placeholder="Мета-тег Description">{{ old('meta_description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Мета-тег Keywords</label>
                                                <div class="col-md-10">
                                                    <textarea id="meta_keywords" name="meta_keywords" rows="5" type="text" class="form-control" placeholder="Мета-тег Keywords">{{ old('meta_keywords') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-2"></label>
                                                <div class="col-md-10">
                                                    <p class="text-muted m-b-30 font-14">
                                                        * - отмечены обязательные для заполнения поля.
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="form-group" style="display: none;" id="group_errors">
                                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                                    <div class="text-left" id="errors_list">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-2"></label>
                                                <div class="col-md-10">
                                                    <div class="pull-right">
                                                        <button onclick="category.add();" class="btn btn-success btn-lg">Добавить</button>
                                                    </div>
                                                </div>
                                            </div>

                                            {{csrf_field()}}
                                        </form>
                                    </div>
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
    <script src="{{ asset('assets/admin/js/category.js')}}"></script>
@endsection