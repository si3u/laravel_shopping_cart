@extends('layouts.main')

@section('title', 'ArtVitrina | News')

@section('content')
    @include('includes.header')
    <div class="main-content">
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-8 col-md-8 has-sidebar-right">
                            <div id="main" class="site-main">
                                <div class="blog-wrap">
                                    @if (count($news) > 0)
                                        @foreach ($news as $item)
                                            <?php //$dt = \Carbon\Carbon::parse($item->created_at); echo $dt->toFormattedDateString(); ?>
                                            <article class="blog-item">
                                                <header class="entry-header">
                                                    <h3 class="entry-title post-title"><a rel="bookmark" href="{{ route('public.show_news', ['id' => $item->id]) }}">{{$item->topic}}</a></h3>
                                                </header>
                                                <div class="media-post">
                                                    <figure>
                                                        <a href="{{ route('public.show_news', ['id' => $item->id]) }}">
                                                            <img src="{{ asset('assets/images/news/'.$item->image_preview)}}" alt="img">
                                                        </a>
                                                    </figure>
                                                    <div class="post-time">
                                                        <a href="{{ route('public.show_news', ['id' => $item->id]) }}">
                                                            <span class="post-date">{{$item->created_at}}</span>
                                                            <span>ВЕР</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="post-description">
                                                    {!! strip_tags(str_limit($item->text, 250)) !!}
                                                </div>
                                                <a class="readmore-link" href="{{ route('public.show_news', ['id' => $item->id]) }}">{{__('news.to_read')}} <i class="flaticon-arrow-pointing-to-right"></i></a>
                                            </article>
                                        @endforeach
                                    @endif
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

                        @include('includes.paginate', ['paginator' => $news])
                    </div>
                </div>
            </div>
        </div>
@endsection
