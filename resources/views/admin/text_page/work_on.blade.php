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
                            <h4 class="page-title">{{$page->title}} | {{$page->item->name}}</h4>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-box">
                        <form id="form_save_text_page" class="form-horizontal" action="{{route('admin/text_page/update')}}" onclick="return false;">
                            <input type="hidden" name="item_id" value="{{$page->item->id}}">
                            <div class="form-group">
                                <div id="value" name="value" class="summernote">{!! $page->item->value !!}</div>
                            </div>
                            <div class="form-group" style="display: none;" id="group_errors">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <div class="text-left" id="errors_list">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="pull-right">
                                    <button class="btn btn-success btn-lg" onclick="textPage.save()">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')
    {!! script_ts('/assets/admin/my_js_scripts/textPage.js') !!}
@endsection
