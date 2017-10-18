@extends('layouts.main')

@section('title', 'ArtVitrina | News')

@section('content')
    @include('includes.header')
    <div class="main-content">
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12 col-lg-9 col-lg-offset-1 has-sidebar-right sf_top_0 sf_dryk">
                            <div id="main" class="site-main">
                                <div class="blog-single">
                                    <article class="blog-item">
                                        <div class="blog-content">
                                            <div class="col-md-12">

                                                @include('includes.print.form')

                                                <div class="col-md-6">
                                                    {!! __('print.rigth') !!}
                                                </div>
                                            </div>

                                            {!! __('print.body') !!}

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
@section('my_scripts')
    {!! script_ts('/assets/js/project/print.js') !!}
@endsection
