@extends('app')


@section('title')
    Notifications
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
            <h1 class="page-heading">Notifications</h1>
        </div>
        <div class="col-sm-12 page-subheading">
            <p>
                {{ $notifications->where('read', 0)->count() }}
                @if ($notifications->where('read', 0)->count() == 1)
                    unread notification.
                @else
                    unread notifications.
                @endif
            </p>
        </div>
    </div>


    <div class="notification-list-container">
        @foreach ($notifications as $notification)
            <div class="row">
                <div class="col-sm-12 col-md-6 notification-container @if(!$notification->read) notification-unread @endif">
                    <a href="/notifications/{{ $notification->id }}">
                        <div>
                            <p>
                                New <b>{{ $notification->type }}</b>(s) on your post
                                '<b>{{ $notification->article()->first()->title }}</b>'.
                            </p>
                            <div class="notification-stats">
                                <span class="notification-read-indicator">
                                    @if ($notification->read)
                                        Read
                                    @else
                                        Unread
                                    @endif
                                </span>
                                <i class="fa fa-dot-circle-o"></i>
                                <span class="notification-timestamp">
                                    {{ $notification->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

@stop
