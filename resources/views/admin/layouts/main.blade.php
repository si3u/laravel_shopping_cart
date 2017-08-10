<!DOCTYPE html>
<html>
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
    {!! style_ts('/assets/admin/plugins/summernote/summernote.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery-toastr/jquery.toast.min.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery.filer/css/jquery.filer.css') !!}
    {!! style_ts('/assets/admin/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}
    {!! style_ts('/assets/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.css') !!}
    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" rel="stylesheet">
</head>
<body>
{{ csrf_field() }}
@yield('content')
@include('admin.active_localization.modal')
<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
{!! script_ts('/assets/admin/js/bootstrap.min.js') !!}
{!! script_ts('/assets/admin/js/metisMenu.min.js') !!}
{!! script_ts('/assets/admin/js/waves.js') !!}
{!! script_ts('/assets/admin/js/jquery.slimscroll.js') !!}
{!! script_ts('/assets/admin/plugins/waypoints/jquery.waypoints.min.js') !!}
{!! script_ts('/assets/admin/plugins/counterup/jquery.counterup.min.js') !!}
{!! script_ts('/assets/admin/plugins/d3/d3.min.js') !!}
{!! script_ts('/assets/admin/plugins/c3/c3.min.js') !!}
{!! script_ts('/assets/admin/plugins/jquery-toastr/jquery.toast.min.js') !!}
{!! script_ts('/assets/admin/pages/jquery.dashboard.js') !!}
{!! script_ts('/assets/admin/js/jquery.core.js') !!}
{!! script_ts('/assets/admin/js/jquery.app.js') !!}
{!! script_ts('/assets/admin/plugins/summernote/summernote.min.js') !!}
{!! script_ts('/assets/admin/plugins/responsive-table/js/rwd-table.min.js') !!}

{!! script_ts('/assets/admin/my_js_scripts/common.js') !!}

<script>
    jQuery(document).ready(function(){
        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['height', ['height']],
            ],
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
        $('.characteristics').summernote({
            toolbar: [
                ['table', ['table']]
            ],
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
    });
</script>

@yield('my_scripts')

</body>
</html>