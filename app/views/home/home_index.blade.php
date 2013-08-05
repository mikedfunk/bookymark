@extends('layouts.master')

@section('html_head_content')
<title>Bookymark Home</title>
@stop

@section('main_content')
<div class="row">
  <div class="col-lg-9">
    <h1>Bookymark</h1>
    <p class="lead">An example bookmarking project that lets you add, edit,
    create, and delete bookmarks.</p>
  </div><!--col-->
  <div class="col-lg-3"><h4>Want to take it for a spin?</h4>
    <a class="btn btn-large btn-primary" href="{{ route('auth.register') }}">Register</a>
    <!-- <a class="btn btn-large btn-default" href="">Login</a> -->
  </div><!--col-->
</div><!--row-->
<div class="row">
  <div class="col-lg-3">
    <h2>Laravel</h2>
    <p>You can use this as a boilerplate <a href="http://laravel.com">Laravel 4</a>
    project. It has authentication, pagination, and CRUD.</p>
  </div><!--col-->
  <div class="col-lg-3">
    <h2>Basset</h2>
    <p>Combine and minify js and css in production and bust caches with build script
    compilation. Keep them separate and indented in development environments, with
    dynamic compilation. <a href="https://github.com/jasonlewis/basset">It's
      the best of both worlds</a>, and it's automated for both environments.</p>
  </div><!--col-->
  <div class="col-lg-3">
    <h2>Unit Tests</h2>
    <p>This was written with tests first. You might find some useful
    <a href="http://phpunit.de">PHPUnit</a> examples
    in app/tests.</p>
  </div><!--col-->
  <div class="col-lg-3">
    <h2>Twitter Bootstrap</h2>
    <p>
    This uses all <a href="http://twitter.github.com/bootstrap/">bootstrap</a>
    responsive markup. Feel free to reuse snippets.
    </p>
  </div><!--col-->
</div><!--row-->
@stop
