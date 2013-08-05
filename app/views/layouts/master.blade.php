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
  </div><!--container-->
</div><!--navbar-->
  <div class="container">
@yield('main_content')
</div><!--container-->
</body>
</html>
