@extends('app')

@section('title')
    New Article
@stop

@section('content')

    <form method="POST" accept-charset="UTF-8" action="/articles">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" name="title" value="{{ old('title') }}">
        <input type="textarea" name="body" value="{{ old('body') }}">
        <button type="submit">Post</button>
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop
