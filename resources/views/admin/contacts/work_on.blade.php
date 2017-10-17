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
                        <form id="form_save_contacts" class="form-horizontal" action="javascript:void(0);">
                            {{csrf_field()}}
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
                                            <?php $path = 'admin.contacts.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @else
                                        <div class="tab-pane" id="{{$item->lang}}">
                                            <?php $path = 'admin.contacts.form_'.$item->lang; ?>
                                            @include($path)
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><span class="text-danger">*</span> E-mail</label>
                                <div class="col-md-10">
                                    <input id="email" name="email" value="{{ $page->contact->email }}" class="form-control" placeholder="Введите E-mail">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"><span class="text-danger">*</span> Телефон</label>
                                <div class="col-md-10">
                                    <input id="tel" name="tel" value="{{ $page->contact->tel }}" class="form-control" placeholder="Введите телефон">
                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="group_errors">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <div class="text-left" id="errors_list">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="pull-right">
                                    <button class="btn btn-success btn-lg" onclick="contacts.save()">Сохранить</button>
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
    {!! script_ts('/assets/admin/js/project/contacts.js') !!}
@endsection
