<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="{{ asset('assets/admin/plugins/c3/c3.min.css') }}" rel="stylesheet" type="text/css"  />

    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/plugins/responsive-table/css/rwd-table.min.css') }}" rel="stylesheet" type="text/css" media="screen">
    <link href="{{ asset('assets/admin/plugins/summernote/summernote.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.css" rel="stylesheet">

    <script src="{{ asset('assets/admin/js/modernizr.min.js') }}"></script>
</head>
<body>
{{ csrf_field() }}
@yield('content')

<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/waves.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/counterup/jquery.counterup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/plugins/d3/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/plugins/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jquery-toastr/jquery.toast.min.js') }}"></script>
<script src="{{ asset('assets/admin/pages/jquery.dashboard.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.core.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.app.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{ asset('assets/admin/plugins/responsive-table/js/rwd-table.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/admin/js/common.js')}}"></script>

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