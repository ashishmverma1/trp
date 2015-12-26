@extends('app')

@section('title')
    Authors
@stop

@section('content')

    <h1>Users</h1>

    @foreach ($users as $user)

        <div>
            <p>
                <a href="/users/{{ $user->username }}">
                    {{ $user->username }}
                    @if ($user->numberOfArticles == 1)
                        ({{ $user->numberOfArticles }} article)
                    @else
                        ({{ $user->numberOfArticles }} articles)
                    @endif
                </a>
            </p>
        </div>

        <hr>

    @endforeach

@stop
