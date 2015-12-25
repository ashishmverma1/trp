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

</head>

<body>

    <div class="header">
        <h2 style="text-align:center;">--Header--</h2>
    </div>

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

</body>

</html>
