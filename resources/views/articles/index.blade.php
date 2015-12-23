@extends('app')

@section('title')
    Articles
@stop

@section('content')

    <h1>Articles</h1>

    @foreach ($articles as $article)

        <article>
            <h3>
                <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
            </h3>

            <p>
                {{ $article->body }}
            </p>
        </article>

        <hr>

    @endforeach

@stop
