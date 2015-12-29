@extends('app')


@section('title')
    New Article
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
            <h1 class="page-heading">New Article</h1>
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


    <div class="row">
        <div class="col-sm-12 col-md-8 article-form">
            <form role="form" method="POST" accept-charset="UTF-8" action="/articles">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group title-section">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title') }}"
                            placeholder="Title for your new article">
                </div>

                <div class="form-group body-section">
                    <label for="body">Body</label>
                    <textarea  class="form-control" type="textarea" rows="10" name="body" placeholder="Body">{{ old('body') }}</textarea>
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit">
                    <i class="fa fa-send"></i> Post
                </button>
            </form>
        </div>
    </div>

@stop
