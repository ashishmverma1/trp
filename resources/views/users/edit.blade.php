@extends('app')


@section('title')
    Reset Password
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
            <h1 class="page-heading">Reset Password</h1>
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
            <form role="form" method="POST" accept-charset="UTF-8" action="/users/{{ $user->username }}/resetpassword">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PATCH">

                <div class="form-group">
                    <input class="form-control" type="password" name="old_password" placeholder="Old password">
                </div>

                <div class="form-group">
                    <label for="password">
                        Minimum <b>four</b> characters.
                    </label>
                    <input class="form-control" type="password" name="password" placeholder="New password">
                </div>

                <div class="form-group">
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password">
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                    <i class="fa fa-refresh"></i> Change Password
                </button>
            </form>
        </div>
    </div>

@stop
