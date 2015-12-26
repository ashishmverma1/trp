@extends('app')

@section('title')
    {{ $user->username }}
@stop

@section('content')

    <h1>{{ $user->username }}'s profile</h1>
    <p>Joined: {{ $user->created_at->toFormattedDateString() }}</p>

    <p>
        @if ($user->numberOfArticles == 1)
            {{ $user->numberOfArticles }} article
        @else
            {{ $user->numberOfArticles }} articles
        @endif
    </p>
    
    @if ($user->numberOfArticles > 0)
        @foreach ($user->articles as $article)
            <div>
                <p>
                    <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                </p>
            </div>

            <hr>
        @endforeach
    @endif

@stop
