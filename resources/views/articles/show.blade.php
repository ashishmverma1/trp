@extends('app')

@section('title')
    {{ $article->title }}
@stop

@section('content')

    <h1>{{ $article->title }}</h1>

    <p>{{ $article->body }}</p>

    <p>
        Published on: {{ $article->created_at->toFormattedDateString() }} ({{ $article->created_at->diffForHumans() }})
    </p>

    @if ($article->created_at != $article->updated_at)
        <p>
              Updated on: {{ $article->updated_at->toFormattedDateString() }} ({{ $article->updated_at->diffForHumans() }})
        </p>
    @endif

    @if (Auth::check() and $article->user_id == Auth::user()->id)
        <a href="/articles/{{ $article->id }}/edit"><button>Edit</button></a>

        <form method="POST" accept-charset="UTF-8" action="/articles/{{ $article->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Delete</button>
        </form>
    @endif

    <h2>Comments:</h2>
    @foreach ($article->comments()->get() as $comment)
        <p>
            <a href="#">{{ $comment->user->username }}</a> says:
        </p>
        <p>
            {{ $comment->body }}

            @if (Auth::check() and $comment->user_id == Auth::user()->id)
                <form method="POST" accept-charset="UTF-8" action="/articles/deletecomment/{{ $comment->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">X</button>
                </form>
            @endif
        </p>
        <p>
            {{ $comment->created_at->diffForHumans() }}
        </p>

        <hr>
    @endforeach


    @if (Auth::check())
        <form method="POST" accept-charset="UTF-8" action="/articles/{{ $article->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <input type="textarea" name="body" value="{{ old('body') }}">
            <button type="submit">Post</button>
        </form>
    @endif

@stop
