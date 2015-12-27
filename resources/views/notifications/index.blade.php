@extends('app')

@section('title')
    Notifications
@stop

@section('content')

    <h1>Notifications</h1>
    <p>{{ $notifications->where('read', 0)->count() }} new notifications.</p>

    @foreach ($notifications as $notification)

        <a href="/notifications/{{ $notification->id }}"
            <div>
                <p>
                    @if ($notification->read)
                        Read:
                    @else
                        Unread:
                    @endif
                </p>
                <p>
                    New {{ $notification->type }}(s) on {{ $notification->article()->first()->title }}
                </p>
            </div>
        </a>

        <hr>

    @endforeach

@stop
