<!doctype html>
<html>
<head>
@stylesheets('application')
@javascripts('application')
@yield('html_head_content')
</head>
<body>
  <div class="navbar navbar-static-top">
  <div class="container">
    <a class="navbar-brand" href="">Bookymark</a>
    <p class="navbar-text pull-right">
    @if($logged_in_user)
    <a href="{{ route('auth.profile') }}">Logged in as {{ $logged_in_user->email }}</a>
    @else
    <a href="{{ route('auth.login') }}">Login</a>
    @endif
    </p>
  </div><!--container-->
</div><!--navbar-->
  <div class="container">
@yield('main_content')
</div><!--container-->
</body>
</html>
