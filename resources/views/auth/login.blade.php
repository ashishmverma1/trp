@extends('app')

@section('title')
  New Article
@stop

@section('content')

  <form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div>
        Pen Name
        <input type="text" name="username" value="{{ old('username') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit">Login</button>
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
