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
                                @if($page->route_name == 'wallpaper/reviews/search')
                                    <li>
                                        <a href="{{route('wallpaper/reviews/search')}}">
                                            <i class="dripicons-arrow-thin-left"></i> Ко всем отзывам
                                        </a>
                                    </li>
                                @endif
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @include('admin.items.wallpaper.reviews.form_search')
                        <div class="card-box">
                            @include('admin.includes.alerts.success_alerts')
                            @include('admin.includes.alerts.error_alerts')
                            <table class="table table-striped m-0">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th></th>
                                    <th class="text-center">Товар</th>
                                    <th class="text-center">Рейтинг</th>
                                    <th class="text-center">Автор</th>
                                    <th class="text-center">E-mail автора</th>
                                    <th class="text-center">Статус</th>
                                    <th class="text-center">Дата добавления</th>
                                    <th class="text-center">Операции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($page->reviews) > 0)
                                    @foreach($page->reviews as $review)
                                        <tr>
                                            <td class="text-center">
                                                {{$review->id}}
                                                @if(!$review->read_status)
                                                    <span class="badge badge-danger pull-right">New</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <img src="/assets/images/wallpapers/{{$review->wallpaper_image}}" alt="image" class="img-responsive thumb-md">
                                            </td>
                                            <td>
                                                <a href="{{route('admin/wallpaper/update_page', ['id' => $review->wallpaper_id])}}" target="_blank">
                                                    {{$review->product_name}}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div id="readOnly">
                                                @for($i = 0; $i<$review->rating; $i++)
                                                    <i class="fa fa-star text-danger"></i>&nbsp;
                                                @endfor
                                                @for($i = $review->rating; $i<5; $i++)
                                                    <i class="fa fa-star-o text-muted"></i>
                                                @endfor
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{$review->name}}
                                            </td>
                                            <td>
                                                {{$review->email}}
                                            </td>
                                            <td class="text-center">
                                                @if($review->check_status)
                                                    Включен
                                                @else
                                                    Выключен
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{$review->created_at}}
                                            </td>
                                            <td>
                                                <div class="btn-group m-b-10">
                                                    <a href="{{route('wallpaper/review/page_update', ['id' => $review->id])}}" type="button" class="btn btn-primary waves-effect waves-light btn-sm">
                                                        <i class="dripicons-pencil"></i>
                                                    </a>
                                                    <button onclick="review.delete({{$review->id}});" class="btn btn-danger waves-effect waves-light btn-sm">
                                                        <i class="dripicons-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">
                                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                По запросу нет отзывов.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                            <div class="text-center">
                                {{$page->reviews->appends(request()->input())->render()}}
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
