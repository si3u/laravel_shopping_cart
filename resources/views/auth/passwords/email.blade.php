@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="wrapper-page">
                        <div class="account-pages">
                            <div class="account-box" style="max-width: 600px;">
                                <div class="account-logo-box">
                                    <h2 class="text-uppercase text-center">
                                        <a href="{{route('admin/login')}}" class="text-success">
                                            <span>{{$_SERVER['SERVER_NAME']}}</span>
                                        </a>
                                    </h2>
                                    <span class="help-block text-center">
                                        Введите E-mail который указали в Админ.панеле на случай если забудете пароль и Вам отправится ссылка на его восстановление.
                                    </span>
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}
                                        <div class="text-center form-group">
                                            @if (session('status'))
                                                <div class="alert alert-success">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="email" placeholder="Введите E-Mail" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                {!! app('captcha')->display() !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" style="height: 50px;" class="btn btn-primary btn-block btm-lg">
                                                    Восстановить пароль
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
