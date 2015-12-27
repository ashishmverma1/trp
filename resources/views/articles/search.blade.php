@extends('app')


@section('title')
    Search
@stop


@section('css')
@stop


@section('js')
@stop


@section('content')

    <h3>Search for: "{{ \Request::get('query') }}"</h3>
    @if ($articles->count() == 1)
        <p>{{ $articles->count() }} result</p>
    @else
        <p>{{ $articles->count() }} results</p>
    @endif

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
