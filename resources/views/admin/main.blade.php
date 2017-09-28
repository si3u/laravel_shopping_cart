@extends('admin.layouts.main')
@section('title')
    {{$_SERVER['HTTP_HOST']}}
@endsection
@section('content')
    <div id="wrapper">
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')
    </div>
    <div class="content-page">
        <div class="content">
            <div class="container">

            </div>
        </div>
    </div>
@endsection