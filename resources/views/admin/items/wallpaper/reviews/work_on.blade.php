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
        <input type="hidden" name="now_rating" value="{{$page->review->rating}}">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{$page->title}}</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="{{route('wallpaper/reviews')}}">
                                        <i class="dripicons-arrow-thin-left"></i> Ко всем отзывам
                                    </a>
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-7">
                                    <p class="text-center text-custom font-13">
                                        <strong>Комментарий</strong>
                                    </p>
                                    <hr>
                                    <form id="form_work_on" action="javascript:void(0);" class="form-horizontal">
                                        <input id="id" name="id" type="hidden" value="{{$page->review->id}}">
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label">
                                                Имя автора
                                            </label>
                                            <div class="col-md-9">
                                                <input value="{{$page->review->name}}" id="name" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-md-3 control-label">
                                                E-mail автора
                                            </label>
                                            <div class="col-md-9">
                                                <input value="{{$page->review->email}}" id="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="col-md-3 control-label">
                                                Сообщение
                                            </label>
                                            <div class="col-md-9">
                                                <textarea id="message" name="message" rows="3" class="form-control">{{$page->review->message}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Рейтинг</label>
                                            <div class="col-md-9">
                                                <div id="rating" style="cursor: pointer;" class="text-center fa-lg">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="col-md-3 control-label">
                                                Статус
                                            </label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1"
                                                            @if($page->review->check_status)
                                                            selected
                                                            @endif >Включен</option>
                                                    <option value="0"
                                                            @if(!$page->review->check_status)
                                                            selected
                                                            @endif >Выключен</option>
                                                </select>
                                                <span class="help-block">
                                                    <small>
                                                        Выберите статус чтобы включить или выключить комментарий для вывода на странице товара.
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                        @include('admin.includes.alerts.error_ajax')
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">
                                            </label>
                                            <div class="col-md-9">
                                                <div class="pull-right">
                                                    <button type="button" onclick="$('#modal_wallpaper_review_delete').modal('show');" class="btn btn-lg btn-danger">
                                                        Удалить
                                                    </button>
                                                    <button type="submit" class="btn btn-lg btn-success">
                                                        Сохранить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-5">
                                    <p class="text-center text-custom font-13">
                                        <strong>Информация о фотообоях</strong>
                                    </p>
                                    <hr>
                                    <div class="thumbnail">
                                        <img src="/assets/images/wallpapers/{{$page->review->wallpaper_image}}" class="img-responsive">
                                        <div class="caption">
                                            <dl class="dl-horizontal">
                                                <dt>Артикул:</dt>
                                                <dd>{{$page->review->vendor_code}}</dd>
                                                <dt>Наименование:</dt>
                                                <dd>{{$page->review->product_name}}</dd>
                                            </dl>
                                            <p class="text-right">
                                                <a target="_blank" href="{{route('admin/wallpaper/update_page', ['id' => $page->review->wallpaper_id])}}" class="btn btn-lg btn-primary waves-effect waves-light" role="button">
                                                    Открыть фотообои
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.items.wallpaper.reviews.modal_delete')
@endsection
@section('my_scripts')
    <script src="{{asset('/assets/admin/plugins/raty-fa/jquery.raty-fa.js')}}"></script>
    {!! script_ts('/assets/admin/js/project/wallpaperReview.js') !!}
@endsection
