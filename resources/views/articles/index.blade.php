@extends('app')

@section('title')
    Articles
@stop

@section('content')

    <h1>Articles</h1>

    <!-- show sorting options -->
    @if (\Request::get('sortby') == '')
        Latest
    @else
        <a href="/articles">Latest</a>
    @endif
    *
    @if (\Request::get('sortby') == 'toprated')
        Top Rated
    @else
        <a href="/articles?sortby=toprated">Top Rated</a>
    @endif
    *
    @if (\Request::get('sortby') == 'mostviewed')
        Most Viewed
    @else
        <a href="/articles?sortby=mostviewed">Most Viewed</a>
    @endif
    <!-- sorting options end -->

    @foreach ($articles as $article)

        <article>
            <h3>
                <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
            </h3>

            <p>
                Posted on: {{ $article->created_at->toFormattedDateString() }} <br>
                Views: {{ $article->view_count }} <br>
                Rating: {{ $article->votes }} <br>
            </p>

            <p>
                {{ $article->body }}
            </p>
        </article>

        <hr>

    @endforeach

@stop
