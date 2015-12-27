<!doctype HTML>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>
        TRP - @yield('title')
    </title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/app.css">
    @yield('css')

</head>

<body>

    <!-- Header navbar -->

    <div class="navbar navbar-inverse navbar-static-top" role="navigation">

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
    			<li><a href="/articles">Articles</a></li>
                @if (Auth::check())
        			<li><a href="/articles/create">Write</a></li>
        			<li><a href="/users/{{ Auth::user()->username }}">Profile</a></li>
        			<li><a href="/auth/logout">Logout</a></li>
                @else
                    <li><a href="/auth/login">Login</a></li>
                    <li><a href="/auth/register">Register</a></li>
                @endif
    		</ul>

    		<div class="col-sm-3 col-md-3 pull-right">
        		<form class="navbar-form" role="search" method="GET" action="/articles/search">
            		<div class="input-group">
            			<input type="text" class="form-control" placeholder="Search Article" name="query" id="srch-term">
            			<div class="input-group-btn">
            				<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
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

    <div class="footer">
        <h2 style="text-align:center;">--Footer--</h2>
    </div>


    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    @yield('js')

</body>

</html>
