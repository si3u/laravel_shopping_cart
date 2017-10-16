@extends('layouts.main')

@section('title', 'ArtVitrina | text page')

@section('content')
    @include('includes.header')
    <div class="main-content">
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-offset-2 has-sidebar-right sf_top_0">
                            <div id="main" class="site-main">
                                <div class="blog-single">
                                    <article class="blog-item">
                                        <div class="blog-content">
                                            {!! $value !!}
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
