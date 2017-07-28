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
            <input type="hidden" id="item_id" value="null">

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
                            <ul class="nav nav-tabs tabs-bordered nav-justified">
                                <?php $i = 0; ?>
                                @foreach($page->active_lang as $item)
                                    @if ($i == 0)
                                            <li class="active">
                                                <a href="#{{$item->lang}}" data-toggle="tab" aria-expanded="false">
                                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                                    <span class="hidden-xs">{{$item->name}}</span>
                                                </a>
                                            </li>
                                    @else
                                            <li class="">
                                                <a href="#{{$item->lang}}" data-toggle="tab" aria-expanded="false">
                                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                                    <span class="hidden-xs">{{$item->name}}</span>
                                                </a>
                                            </li>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                @foreach($page->active_lang as $item)
                                    @if ($i == 0)
                                        <div class="tab-pane active" id="{{$item->lang}}">
                                            <?php $path = 'admin.categories.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @else
                                        <div class="tab-pane" id="{{$item->lang}}">
                                            <?php $path = 'admin.categories.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    <script src="{{ asset('assets/admin/my_js_scripts/category.js')}}"></script>
@endsection