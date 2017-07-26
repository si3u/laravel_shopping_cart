<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Вход</title>
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
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="wrapper-page">
                    <div class="account-pages">
                        <div class="account-box">
                            <div class="account-logo-box">
                                <h2 class="text-uppercase text-center">
                                    <a href="{{$_SERVER['SERVER_NAME']}}" class="text-success">
                                        <span>{{$_SERVER['SERVER_NAME']}}</span>
                                    </a>
                                </h2>
                                <h5 class="text-uppercase font-bold m-b-5 m-t-50">Вход в панель управления</h5>
                            </div>
                            <div class="account-content">
                                <form method="post" action="{{ route('admin/sign_in') }}" class="form-horizontal">
                                    <div class="form-group m-b-20">
                                        <div class="col-xs-12">
                                            <label for="login">Логин</label>
                                            <input class="form-control" value="{{ old('login') }}" name="login" required="" placeholder="Введите логин">
                                        </div>
                                    </div>

                                    <div class="form-group m-b-20">
                                        <div class="col-xs-12">
                                            <label for="password">Пароль</label>
                                            <input class="form-control" value="{{ old('password') }}" type="password" name="password" placeholder="Введите пароль">
                                        </div>
                                    </div>
                                    <div class="form-group text-center m-b-20">
                                        <div class="col-xs-12">
                                            @if (count($errors) > 0)
                                                @foreach ($errors->all() as $error)
                                                    <div class="alert alert-danger alert-white alert-dismissible fade in" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group text-center m-t-10">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-md btn-block btn-primary waves-effect waves-light">Войти</button>
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>

</body>

</html>