@extends('app')

@section('title')
    {{ $article->title }}
@stop

@section('content')

    <!-- Show  article stuff -->
    <h1>{{ $article->title }}</h1>

    <p>Posted by: <a href="/users/{{ $article->user->username }}">{{ $article->user->username }}</a></p>

    <p>{{ $article->body }}</p>

    <p>
        Published on: {{ $article->created_at->toFormattedDateString() }} ({{ $article->created_at->diffForHumans() }})
    </p>

    @if ($article->created_at != $article->updated_at)
        <p>
              Updated on: {{ $article->updated_at->toFormattedDateString() }} ({{ $article->updated_at->diffForHumans() }})
        </p>
    @endif
    <!-- article stuff ends -->


    <!-- show edit and delete buttons to auth user -->
    @if (Auth::check() and $article->user_id == Auth::user()->id)
        <a href="/articles/{{ $article->id }}/edit"><button>Edit</button></a>

        <form method="POST" accept-charset="UTF-8" action="/articles/{{ $article->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Delete</button>
        </form>
    @endif
    <!-- edit and delete buttons end -->


    <!-- show rating buttons -->
    <p id="rating-counter">
        Rating: {{ $article->upvotes - $article->downvotes }}
    </p>
    @if (Auth::check())
            <button id="upvote-button" class="vote-button" data-vote-type="upvote"
                                                            data-action="/articles/{{ $article->id }}/vote"
                                                            data-article="{{ $article->id }}"
                                                            data-token="{{ csrf_token() }}">
                Upvote ({{ $article->upvotes }})
            </button>
            <button id="downvote-button" class="vote-button" data-vote-type="downvote"
                                                            data-action="/articles/{{ $article->id }}/vote"
                                                            data-article="{{ $article->id }}"
                                                            data-token="{{ csrf_token() }}">
                Downvote ({{ $article->downvotes }})
            </button>
    @endif
    <!-- rating buttons end -->


    <!-- Show all comments -->
    <h2>Comments:</h2>
    @foreach ($article->comments()->get() as $comment)
        <p>
            <a href="/users/{{ $comment->user->username }}">{{ $comment->user->username }}</a> says:
        </p>
        <p>
            {{ $comment->body }}

            <!-- delete comment if auth user -->
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
    <!-- Show all comments end -->


    <!-- post new comment by auth user -->
    @if (Auth::check())
        <form method="POST" accept-charset="UTF-8" action="/articles/{{ $article->id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <input type="textarea" name="body" value="{{ old('body') }}">
            <button type="submit">Post</button>
        </form>
    @endif
    <!-- post comment end -->

@stop
