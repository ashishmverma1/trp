@extends('app')

@section('title')
  New Article
@stop

@section('content')

  <h1>Updating: {{ $article->title }}</h1>

  <form method="POST" accept-charset="UTF-8" action="/trp/public/articles/{{ $article->id }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="PATCH">
    <input type="text" name="title" value="{{ $article->title }}">
    <input type="textarea" name="body" value="{{ $article->body }}">
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
