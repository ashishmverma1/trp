@extends('app')


@section('title')
    Authors
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
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-heading">Authors</h1>
        </div>
        <div class="col-sm-12 page-subheading">
            <p>
                {{ $users->count() }} authors
            </p>
        </div>
    </div>


    <div class="row user-list-container">
        @foreach ($users as $user)
            <div class="col-sm-12 col-md-3 user-preview-col">
                <a href="/users/{{ $user->username }}">
                    <div class=" user-preview-container">
                        <div class="user-preview-title">
                            <p>
                                {{ $user->username }}
                            </p>
                        </div>

                        <div class="user-preview-stats">
                            <p>
                                <i class="fa fa-group"></i> Joined on: {{ $user->created_at->toFormattedDateString() }}
                            </p>
                            <p>
                                <i class="fa fa-pencil-square"></i> Articles published: {{ $user->numberOfArticles }}
                            </p>
                            <p>
                                <i class="fa fa-comments"></i> Comments posted: {{ $user->comments()->count() }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@stop
