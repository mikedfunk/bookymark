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
  <div class="col-lg-3">
    <div class="panel panel-success text-center">
      <div class="panel-heading">
        Want to take it for a spin?
      </div><!--panel-heading-->
      <a class="btn btn-large btn-primary" href="{{ route('auth.register') }}">
        <span class="glyphicon glyphicon-user"></span> Register</a>
    </div><!--panel-->
  </div><!--col-->
</div><!--row-->
<div class="row">
  <div class="col-lg-3">
    <h2>Laravel</h2>
    <p>You can use this as a boilerplate <a href="http://laravel.com">Laravel 4</a>
    project. It has authentication, pagination, and CRUD.</p>
  </div><!--col-->
  <div class="col-lg-3">
    <h2>PSR-2</h2>
    <p>All classes are in app/src and are autoloaded by namespace. All other language
    features comform to <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md">PSR-2</a>
    standards. Code portability and defined standards FTW!</p>
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
    This uses all <a href="http://getbootstrap.org">Twitter Bootstrap 3</a>
    responsive markup. Feel free to reuse snippets.
    </p>
  </div><!--col-->
</div><!--row-->
@stop
