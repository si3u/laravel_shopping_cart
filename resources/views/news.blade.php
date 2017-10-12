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
                                            <article class="blog-item">
                                                <header class="entry-header">
                                                    <h3 class="entry-title post-title"><a rel="bookmark" href="index.php?newsmore">{{$item->topic}}</a></h3>
                                                </header>
                                                <div class="media-post">
                                                    <figure>
                                                        <a href="index.php?newsmore">
                                                            <img src="{{ asset('assets/images/news/'.$item->image_preview)}}" alt="img">
                                                        </a>
                                                    </figure>
                                                    <div class="post-time">
                                                        <a href="index.php?newsmore">
                                                            <span class="post-date">30</span>
                                                            <span>ВЕР</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="post-description">
                                                    {{ $item->text }}
                                                </div>
                                                <a class="readmore-link" href="index.php?newsmore">Детальніше <i class="flaticon-arrow-pointing-to-right"></i></a>
                                            </article>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="secondary" class="sidebar blog-sidebar-area col-xs-12 col-sm-4 col-md-4 sidebar-right">

                            <div class="widget widget_search">
                                <form class="search-form" action="" method="get" role="search">
                                    <input class="search" type="text" name="q" placeholder="Пошук ..." value="">
                                    <button class="search-form-submit" type="submit">
                                        <i class="flaticon-search"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="widget widget_latest_post">
                                <h4 class="title-sidebar">Останні новини</h4>
                                <ul class="recent_posts_list">
                                    <li>
                                        <figure class="post-img">
                                            <a href="index.php?newsmore">
                                                <img width="120"   alt="imgs"  src="assets/images/sfdevelop/b001.jpg">
                                            </a>
                                        </figure>
                                        <div class="recent_posts_content">
                                            <h5 class="title-post"><a href="index.php?newsmore" class="title-post">Остання публікація на сайті</a></h5>
                                            <span class="ts-post-time">ВЕР 30, 2017</span>
                                            <a href="index.php?newsmore" class="readmore-link">Детальніше <i class="flaticon-arrow-pointing-to-right"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <figure class="post-img">
                                            <a href="index.php?newsmore">
                                                <img width="120"   alt="imgs"  src="assets/images/sfdevelop/b001.jpg">
                                            </a>
                                        </figure>
                                        <div class="recent_posts_content">
                                            <h5 class="title-post"><a href="index.php?newsmore" class="title-post">Передостання публікація на сайті</a></h5>
                                            <span class="ts-post-time">ВЕР 30, 2017</span>
                                            <a href="index.php?newsmore" class="readmore-link">Детальніше <i class="flaticon-arrow-pointing-to-right"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <figure class="post-img">
                                            <a href="index.php?newsmore">
                                               <img width="120"   alt="imgs"  src="assets/images/sfdevelop/b001.jpg">
                                            </a>
                                        </figure>
                                        <div class="recent_posts_content">
                                            <h5 class="title-post"><a href="index.php?newsmore" class="title-post">Ще одна публікація на сайті</a></h5>
                                            <span class="ts-post-time">ВЕР 30, 2017</span>
                                            <a href="index.php?newsmore" class="readmore-link">Детальніше <i class="flaticon-arrow-pointing-to-right"></i></a>
                                        </div>
                                    </li>
                                 </ul>
                            </div>

                            <div class="widget widget_tags">
                                <h4 class="title-sidebar">Теги</h4>
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

                            <div class="widget widget_quote">
                                <h4 class="title-sidebar">Цитата дня!</h4>
                                <div class="blog-quote">
                                    <span class="flaticon-left-quote"></span>
                                    <div class="quote-content">
                                        Если проблему можно разрешить, не стоит о ней беспокоиться. Если проблема неразрешима, беспокоиться о ней бессмысленно
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="pagation col-sm-12">
                            <ul class="page-numbers">
                                <li class="prev"><a href="index.php?newsmore" class=" page-number">Попередня</a></li>
                                <li><a href="index.php?newsmore" class="page-number">1</a></li>
                                <li><span class="page-numbers current">2</span></li>
                                <li><a href="index.php?newsmore" class="page-number">3</a></li>
                                <li class="next"><a href="index.php?newsmore" class=" page-number">Наступна</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
