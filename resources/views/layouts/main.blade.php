<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/font-awesome.min.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/themify-icons.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/flaticon.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/owl.carousel.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/slick.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/jquery.mmenu.all.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/lightbox.min.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/chosen.min.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/animate.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/jquery.scrollbar.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/jquery.bxslider.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/style.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/css/sfdevelop.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{asset('assets/fonts/style.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700|Great+Vibes|Montserrat:400,700|Open+Sans:400,400i,600,600i,700,800i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo:400,400i,700,700i|Didact+Gothic&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
</head>
<body>

    @yield('content')

    @include('includes.footer')

    <script type='text/javascript' src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/slick.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/wow.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery.mmenu.all.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/lightbox.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery.scrollbar.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery.bxslider.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery.countdown.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/frontend.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/frontend-plugin.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/jquery.row-grid.js')}}"></script>
    <script type='text/javascript' src="{{asset('assets/js/maska.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    @yield('my_scripts')
</body>
</html>
