@extends('app')

@section('title')
    Reset Password
@stop

@section('content')

    <h1>Reset Password</h1>

    <form method="POST" accept-charset="UTF-8" action="/users/{{ $user->username }}/resetpassword">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PATCH">
        <div>
            Old password <input type="password" name="old_password">
        </div>
        <div>
            New password <input type="password" name="password">
        </div>
        <div>
            Confirm password <input type="password" name="password_confirmation">
        </div>
        <button type="submit">Change</button>
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop
