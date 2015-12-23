@extends('app')

@section('title')
    Register
@stop

@section('content')

    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}

        <div>
            Pen Name
            <input type="text" name="username" value="{{ old('username') }}">
        </div>

        <div>
            Password
            <input type="password" name="password">
        </div>

        <div>
            Confirm Password
            <input type="password" name="password_confirmation">
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop
