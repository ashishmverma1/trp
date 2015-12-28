@extends('app')


@section('title')
    Search
@stop


@section('css')
    <style>
        body {
            background-position: center;
            background-image: url(/img/bg_articles.jpg);
            background-repeat:no-repeat;
            background-attachment: fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
@stop


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-heading">Search for:</h1>
        </div>
        <div class="col-sm-12 search-result">
            <p class="">'{{ \Request::get('query') }}'</p>
            <p>
                @if ($articles->count() == 1)
                    {{ $articles->count() }} result found.
                @else
                    {{ $articles->count() }} results found.
                @endif
            </p>
        </div>
    </div>

    <!-- Show results -->
    @foreach ($articles as $article)

        <div class="row">
            <div class="article-preview-container col-sm-12 col-md-8 col-centered">
                <div class="row article-preview-title">
                    <a href="/articles/{{ $article->id }}">
                        <div class="col-sm-12">
                            <p>
                                {{ $article->title }}
                            </p>
                        </div>
                    </a>
                </div>

                <div class="row article-preview-body">
                    <div class="col-sm-12">
                        <p>
                            {{ str_limit($article->body, $limit = 120,  $end = ' . . .') }}
                        </p>
                    </div>
                </div>

                <div class="row article-preview-stats">
                    <div class="col-sm-12 col-md-6">
                        <p>
                            <i class="fa fa-user"></i> Posted by:
                            <a href="/users/{{ $article->user()->get()->first()->username }}">
                                {{ $article->user()->get()->first()->username }}
                            </a>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <p>
                            <i class="fa fa-clock-o"></i> Posted on: {{ $article->created_at->toFormattedDateString() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@stop
