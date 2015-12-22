<!doctype HTML>
<html lang="en">

<head>

  <meta charset="utf-8">
  <title>
    TRP - @yield('title')
  </title>

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

</body>

</html>
