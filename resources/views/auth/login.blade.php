@extends('app')


@section('title')
    Login
@stop


@section('css')
    <style>
        body {
            background-position: center;
            background-image: url(/img/bg_users.jpg);
            background-repeat:no-repeat;
            background-attachment: fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
@stop


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-heading">Login</h1>
        </div>
    </div>


    @if ($errors->any())
        <div class="row">
            <div class="col-sm-12 col-md-4 auth-form-errors">
                <p>Error!</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12 col-md-4 auth-form">
            <form role="form" method="POST" accept-charset="UTF-8" action="/auth/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <input class="form-control" type="text" name="username" value="{{ old('username') }}"
                            placeholder="Pen Name">
                </div>

                <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <input type="checkbox" name="remember" class="remember-me-checkbox"> Remember Me
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </form>
        </div>
    </div>

@stop
