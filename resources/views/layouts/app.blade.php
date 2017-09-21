<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>
</head>

<body class="bg-accpunt-pages">
@yield('content')
<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>

</body>

</html>
