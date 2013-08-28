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
      <div class="panel-body">
        <a class="btn btn-large btn-primary" href="{{ route('auth.register') }}">
          <span class="glyphicon glyphicon-user"></span> Register</a>
      </div><!--panel-body-->
    </div><!--panel-->
  </div><!--col-->
</div><!--row-->
<div class="row">
  <div class="col-lg-4">
    <h2>Laravel</h2>
    <p>You can use this as a boilerplate <a href="http://laravel.com">Laravel 4</a>
    project. It has authentication, pagination, and CRUD.</p>
  </div><!--col-->
  <div class="col-lg-4">
    <h2>PSR-2</h2>
    <p>All classes are in app/src and are autoloaded by namespace. All other language
    features comform to <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md">PSR-2</a>
    standards. Code portability and defined standards FTW!</p>
  </div><!--col-->
  <div class="col-lg-4">
    <h2>Unit Tests</h2>
    <p>This was written with tests first. You might find some useful
    <a href="http://phpunit.de">PHPUnit</a> examples
    in app/tests. Mocks powered by <a href="https://github.com/padraic/mockery">Mockery</a>.</p>
  </div><!--col-->
</div><!--row-->
<div class="row">
  <div class="col-lg-4">
    <h2>Continuous Integration</h2>
    <p>
    On push to master, it checks unit tests, verifies PSR-2 code standards, and
    deploys <em>if</em> they are successful with <a href="http://travis-ci.org">Travis-CI</a>.
    </p>
  </div><!--col-->
  <div class="col-lg-4">
    <h2>Twitter Bootstrap</h2>
    <p>
    This uses all <a href="http://getbootstrap.org">Twitter Bootstrap 3</a>
    responsive markup. Feel free to reuse snippets.
    </p>
  </div><!--col-->
  <div class="col-lg-4">
    <h2>Google PageSpeed</h2>
    <p>
    All js/css files are combined, minified, and cached via
    <a href="https://github.com/jasonlewis/basset">Basset</a>. All assets are gzipped
    and have far-future expiration dates. These are some of the factors for fast
    front-end performance as measured by <a href="https://developers.google.com/speed/pagespeed/">Google PageSpeed</a>.
    </p>
  </div><!--col-->
</div><!--row-->
@stop
