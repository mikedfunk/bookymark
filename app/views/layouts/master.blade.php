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
    Logged in as <a href="{{ route('auth.profile') }}">
{{ $logged_in_user->email }}</a> <a href="{{ route('auth.logout') }}">Logout</a>
    @else
    <a href="{{ route('auth.login') }}">Login</a>
    @endif
    </p>
  </div><!--container-->
</div><!--navbar-->
  <div class="container">
@yield('title_content')
{{ Notification::showAll() }}
@yield('main_content')
<footer>
<hr>
<p>by <a href="http://mikefunk.com">Mike Funk.</a></p>
</footer>
</div><!--container-->
<a href="https://github.com/bookymark/bookymark">
  <img class="fork_me" height="149" width="149" src="{{ asset('assets/img/forkme_right_orange_ff7600.png') }}" alt="Fork me on GitHub">
</a>
</body>
</html>
