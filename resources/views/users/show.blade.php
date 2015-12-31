@extends('app')


@section('title')
    {{ $user->username }}
@stop


@section('css')
    <style>
        body {
            background-position: center;
            background-image: url(/img/bg_users.jpg);
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

    @if (Auth::check() and $user->id == Auth::user()->id)
        <!-- Article delete modal -->
        <div class="modal fade" id="user-delete-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete your profile?
                        </p>
                        <p>
                            YOUR ACCOUNT AND ALL ASSOCIATED DATA WILL BE DELETED PERMANENTLY!
                        </p>

                        <div>
                            <button type="button" class="btn btn-success" data-dismiss="modal">
                                <i class="fa fa-mail-reply"></i> Cancel
                            </button>
                            <form method="POST" accept-charset="UTF-8" action="/users/{{ $user->username }}"
                                style="display:inline-block">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-close"></i> Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-heading">{{ $user->username }}'s profile</h1>
        </div>

        @if (Auth::check() and $user->id == Auth::user()->id)
            <!-- show edit and delete buttons to auth user -->
            <div class="col-sm-12 page-subheading">
                <a href="/users/{{ $user->username }}/resetpassword" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Change Password
                </a>

                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#user-delete-modal">
                    <i class="fa fa-close"></i> Delete Account
                </button>
            </div>
            <!-- edit and delete buttons end -->
        @endif

        <div class="col-sm-12 page-subheading">
            <p>
            </p>
            <p>
                <i class="fa fa-group"></i> Joined on: {{ $user->created_at->toFormattedDateString() }}
            </p>
            <p>
                <i class="fa fa-comments"></i> Comments posted: {{ $user->comments()->count() }}
            </p>
            <p>
                <i class="fa fa-pencil-square"></i> Articles published: {{ $user->numberOfArticles }}
            </p>
        </div>
    </div>


    @if ($user->numberOfArticles > 0)
        @foreach ($user->articles as $article)

            <div class="row">
                <div class="article-preview-container col-sm-10 col-md-8 col-centered">
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
                        <div class="col-sm-12 col-md-2">
                            <p>
                                <i class="fa fa-eye"></i> Views: {{ $article->view_count }}
                            </p>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <p>
                                <i class="fa fa-thumbs-up"></i> Rating: {{ $article->votes }} <br>
                            </p>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <p>
                                <i class="fa fa-comments"></i> Comments: {{ $article->comments()->count() }} <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        @endforeach
    @endif

@stop
