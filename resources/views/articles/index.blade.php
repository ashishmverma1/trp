@extends('app')


@section('title')
    Articles
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
            <h1 class="page-heading">Articles</h1>
        </div>

        <!-- show sorting options -->
        <div class="col-sm-12 sorting-tab-container">
            @if (\Request::get('sortby') != 'toprated' and \Request::get('sortby') != 'mostviewed')
                <span class="sorting-tab">Latest</span>
            @else
                <a href="/articles"><span class="sorting-tab">Latest</span></a>
            @endif

            @if (\Request::get('sortby') == 'toprated')
                <span class="sorting-tab">Top Rated</span>
            @else
                <a href="/articles?sortby=toprated"><span class="sorting-tab">Top Rated</span></a>
            @endif

            @if (\Request::get('sortby') == 'mostviewed')
                <span class="sorting-tab">Most Viewed</span>
            @else
                <a href="/articles?sortby=mostviewed"><span class="sorting-tab">Most Viewed</span></a>
            @endif
        </div>
        <!-- sorting options end -->
    </div>



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
                    <div class="col-sm-12 col-md-3">
                        <p>
                            <i class="fa fa-user"></i> Posted by:
                            <a href="/users/{{ $article->user()->get()->first()->username }}">
                                {{ $article->user()->get()->first()->username }}
                            </a>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <p>
                            <i class="fa fa-clock-o"></i> Posted on: {{ $article->created_at->toFormattedDateString() }}
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <p>
                            <i class="fa fa-eye"></i> Views: {{ $article->view_count }}
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <p>
                            <i class="fa fa-thumbs-up"></i> Rating: {{ $article->votes }} <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@stop
