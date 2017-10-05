<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {!! style_ts('/assets/admin/plugins/c3/c3.min.css') !!}
    {!! style_ts('/assets/admin/css/bootstrap.min.css') !!}
    {!! style_ts('/assets/admin/css/core.css') !!}
    {!! style_ts('/assets/admin/css/components.css') !!}
    {!! style_ts('/assets/admin/css/icons.css') !!}
    {!! style_ts('/assets/admin/css/pages.css') !!}
    {!! style_ts('/assets/admin/css/menu.css') !!}
    {!! style_ts('/assets/admin/css/responsive.css') !!}
    {!! style_ts('/assets/admin/plugins/responsive-table/css/rwd-table.min.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery-toastr/jquery.toast.min.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery.filer/css/jquery.filer.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}
    {!! style_ts('/assets/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.css') !!}
    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">

    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

    @if($locale)
        <!-- elFinder translation (OPTIONAL) -->
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                lang: 'russian',
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}'
            });
        });
    </script>
</head>
<body>
{{ csrf_field() }}

@yield('content')

@include('admin.active_localization.modal')
@include('admin.includes.modal.contacts')
@include('admin.includes.modal.edit_pass')
@include('admin.includes.modal.change_email')
{!! script_ts('/assets/admin/js/bootstrap.min.js') !!}
{!! script_ts('/assets/admin/js/metisMenu.min.js') !!}
{!! script_ts('/assets/admin/js/jquery.slimscroll.js') !!}
{!! script_ts('/assets/admin/plugins/jquery-toastr/jquery.toast.min.js') !!}
{!! script_ts('/assets/admin/pages/jquery.dashboard.js') !!}
{!! script_ts('/assets/admin/js/jquery.core.js') !!}
{!! script_ts('/assets/admin/js/jquery.app.js') !!}

{!! script_ts('/assets/admin/js/project/common.js') !!}

@yield('my_scripts')

</body>
</html>