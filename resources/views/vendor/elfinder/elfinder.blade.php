@extends('vendor.elfinder.layouts.main')
@section('title')
    Файловый менеджер
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
                            <h4 class="page-title">Файловый менеджер</h4>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-box">
                        <div id="elfinder" style="margin-top: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my_scripts')

@endsection

