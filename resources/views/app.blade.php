<!doctype HTML>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        TRP - @yield('title')
    </title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Titillium+Web:300'>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:300">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    @yield('css')

</head>

<body>

    <!-- Header navbar -->

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    	<div class="navbar-header">
    		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
    		<span class="sr-only">Toggle navigation</span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		</button>
    		<a class="navbar-brand" rel="home" href="/" title="TRP">TRP</a>
    	</div>

    	<div class="collapse navbar-collapse navbar-ex1-collapse">

    		<ul class="nav navbar-nav">
    			<li>
                    <a href="/articles"><i class="fa fa-newspaper-o"></i> Articles</a>
                </li>
                @if (Auth::check())
        			<li>
                        <a href="/articles/create"><i class="fa fa-pencil-square"></i> Write</a>
                    </li>
        			<li>
                        <a href="/notifications"><i class="fa fa-bell"></i> Notifications <span id="notif-indicator"></span></a>
                    </li>
        			<li>
                        <a href="/users/{{ Auth::user()->username }}"><i class="fa fa-user"></i> Profile</a>
                    </li>
        			<li>
                        <a href="/users"><i class="fa fa-users"></i> Authors</a>
                    </li>
        			<li>
                        <a href="/auth/logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                @else
                    <li><a href="/auth/login"><i class="fa fa-sign-in"></i> Login</a></li>
                    <li><a href="/auth/register"><i class="fa fa-user-plus"></i> Register</a></li>
                @endif
    		</ul>

    		<div class="col-sm-3 col-md-3 pull-right">
        		<form class="navbar-form" role="search" method="GET" action="/articles/search">
            		<div class="input-group">
            			<input type="text" class="form-control" placeholder="Search Article" name="query" id="srch-term">
            			<div class="input-group-btn">
            				<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            			</div>
            		</div>
        		</form>
    		</div>

    	</div>
    </div>
    <!-- header ends -->

    <!-- show flash messages if any -->
    @if (Session::has('flash_message'))
        <div>
            {{ Session::get('flash_message') }}
        </div>
    @endif
    <!-- flash messages end -->

    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="footer row">
        <div class="col-md-12">
            &copy; TRP 2016
        </div>
    </div>
    <!-- Footer ends -->


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    @yield('js')

</body>

</html>
