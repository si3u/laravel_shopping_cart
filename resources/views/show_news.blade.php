@extends('layouts.main')

@section('title', 'ArtVitrina | News')

@section('content')
    @include('includes.header')
    <div class="main-content">
        <?php $created = \Carbon\Carbon::parse($news->created_at)->formatLocalized('%d %b %Y'); ?>
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-8 col-md-8 has-sidebar-right">
                            <div id="main" class="site-main">
                                <div class="blog-single">
                                    <article class="blog-item">
                                        <div class="media-post text-center">
                                            <figure>
                                                <img src="{{ asset('assets/images/news/'.$news->image) }}" alt="img">
                                            </figure>
                                            <div class="post-time" style="width: 150px;height: 55px;">
                                                <a href="#">
                                                    <span class="post-date">{{$created}}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <h3 class="text-center">{{ $news->topic }}</h3><br>
                                            {!! $news->text !!}
                                        </div>
                                    </article>

                                    @include('includes.news.comments.form_create')

                                    @include('includes.news.comments.list')
                                </div>
                            </div>
                        </div>

                        <div id="secondary" class="sidebar blog-sidebar-area col-xs-12 col-sm-4 col-md-4 sidebar-right">

                            @include('includes.news.search')

                            @include('includes.news.last_items')

                            <div class="widget widget_tags">
                                <h4 class="title-sidebar">{{__('news.tags')}}</h4>
                                <div class="blog-tags">
                                    <a class="active" href="index.php?newsmore">ВІтрина</a>
                                    <a href="index.php?newsmore">Картини</a>
                                    <a href="index.php?newsmore">Замовити картини</a>
                                    <a href="index.php?newsmore">Модульні картини</a>
                                    <a href="index.php?newsmore">Новини</a>
                                    <a href="index.php?newsmore">Останні новини</a>
                                    <a href="index.php?newsmore">Арт</a>
                                    <a href="index.php?newsmore">Зима</a>
                                    <a href="index.php?newsmore">Художники</a>
                                    <a href="index.php?newsmore">Славетні художники</a>
                                    <a href="index.php?newsmore">POP-ART</a>
                                </div>
                            </div>

                            @include('includes.news.quote_of_day')

                        </div>

                        @if (count($comments) > 0)
                            @include('includes.paginate', ['paginator' => $comments])
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('my_scripts')
    {!! script_ts('/assets/js/project/news.js') !!}
@endsection
