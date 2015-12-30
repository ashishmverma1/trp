@extends('app')


@section('title')
    {{ $article->title }}
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

    <!-- Article delete modal -->
    <div class="modal fade" id="article-delete-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete the article?
                    </p>

                    <div>
                        <button type="button" class="btn btn-success" data-dismiss="modal">
                            <i class="fa fa-mail-reply"></i> Cancel
                        </button>
                        <form method="POST" accept-charset="UTF-8" action="/articles/{{ $article->id }}"
                            style="display:inline-block">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-close"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 col-md-8 article-container">
            <div class="article-title">
                <h1>{{ $article->title }}</h1>
            </div>

            <div class="page-subheading">
                <p class="article-posted-by">
                    <i class="fa fa-user"></i> Posted by:
                    <a href="/users/{{ $article->user->username }}">{{ $article->user->username }}</a>
                </p>
            </div>

            <!-- show edit and delete buttons to auth user -->
            @if (Auth::check() and $article->user_id == Auth::user()->id)
                <div class="page-subheading">
                    <a href="/articles/{{ $article->id }}/edit" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#article-delete-modal">
                        <i class="fa fa-close"></i> Delete
                    </button>
                </div>
            @endif
            <!-- edit and delete buttons end -->

            <!-- article body -->
            <div class="article-body">
                <p>
                    {!! nl2br(e($article->body)) !!}
                </p>
            </div>
            <!-- article body ends -->

            <!-- article stats -->
            <div class="row article-stats">
                <div class="col-sm-12 col-md-6 article-stats-left">
                    <p>
                        <i  class="fa fa-clock-o"></i>
                        <b>Published on</b>: {{ $article->created_at->toFormattedDateString() }}
                        ({{ $article->created_at->diffForHumans() }})
                    </p>

                    @if ($article->created_at != $article->updated_at)
                        <p>
                            <i  class="fa fa-history"></i>
                            <b>Last updated</b>: {{ $article->updated_at->toFormattedDateString() }}
                            ({{ $article->updated_at->diffForHumans() }})
                        </p>
                    @endif

                    <p>
                        <i class="fa fa-eye"></i> <b>Views</b>: {{ $article->view_count }}
                    </p>
                </div>

                <!-- rating stuff -->
                <div class="col-sm-12 col-md-6 article-stats-right">
                    <p>
                        <i class="fa fa-spinner fa-spin rating-ajax-spinner"></i>
                        <i class="fa fa-thumbs-up"></i> <b>Rating</b>:
                        <span id="new-rating-value">{{ $article->upvotes - $article->downvotes }}</span>
                    </p>
                    <p>
                        <button id="upvote-button" @if(!Auth::check()) disabled @endif
                            class="btn btn-success vote-button
                                @if(Auth::check() and $article->user_vote_value != 1) vote-button-unselected @endif"
                            data-vote-type="upvote"
                            data-action="/articles/{{ $article->id }}/vote"
                            data-article="{{ $article->id }}"
                            data-token="{{ csrf_token() }}">
                                <i class="fa fa-thumbs-o-up"></i> Upvote
                                (<span id="new-upvote-value"> {{ $article->upvotes }} </span>)
                        </button>

                        <button id="downvote-button" @if(!Auth::check()) disabled @endif
                            class="btn btn-danger vote-button
                                @if(Auth::check() and $article->user_vote_value != -1) vote-button-unselected @endif"
                            data-vote-type="downvote"
                            data-action="/articles/{{ $article->id }}/vote"
                            data-article="{{ $article->id }}"
                            data-token="{{ csrf_token() }}">
                                <i class="fa fa-thumbs-o-down"></i> Downvote
                                (<span id="new-downvote-value"> {{ $article->downvotes }} </span>)
                        </button>
                    </p>
                </div>
                <!-- rating stuff ends -->
            </div>
            <!-- article stats end -->
        </div>
    </div>



    <div class="row">
        <div class="col-sm-10 col-md-8 comments-container">
            <h2>Comments ({{ $article->comments()->count() }}):</h2>
            <hr>

            @foreach ($article->comments()->get() as $comment)
                <div class="row">
                    <div class="col-sm-12 comment">
                        <p class="comment-heading">
                            <a href="/users/{{ $comment->user->username }}"><b>{{ $comment->user->username }}</b></a> says:
                        </p>

                        <p class="comment-body">
                            {{ $comment->body }}
                        </p>

                        <div class="comment-bottom">
                            {{ $comment->created_at->diffForHumans() }}
                            @if (Auth::check() and $comment->user_id == Auth::user()->id)
                                &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;
                                <!-- delete comment if auth user -->
                                <form method="POST" accept-charset="UTF-8" style="display:inline-block"
                                    action="/articles/deletecomment/{{ $comment->id }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-xs">
                                        <i class="fa fa-times-circle-o fa-2"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>

                        <hr>
                    </div>
                </div>
            @endforeach

            @if (Auth::check())
            <!-- post new comment by auth user -->
                <div class="row" id="post-comment-section">
                    <form role="form" method="POST" accept-charset="UTF-8"
                        action="/articles/{{ $article->id }}#post-comment-section">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <div class="col-sm-12 col-md-10 comment-input">
                                <input class="form-control" type="text" name="body" value="{{ old('body') }}"
                                    placeholder="Have something to say?">
                        </div>

                        <div class="col-sm-12 col-md-2 comment-button">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-send"></i> Post
                            </button>
                        </div>
                    </form>
                </div>
            <!-- post comment end -->
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="row">
            <div class="col-sm-12 col-md-4 article-form-errors">
                <p>Uh no, not there yet! You need to take care of  the following first:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif






@stop
