@extends('layouts.master')

@section('html_head_content')
<title>Login</title>
@stop

@section('title_content')
<div class="row">
  <div class="col-lg-4 col-offset-4">
    <h1>Please Login</h1>
    @stop

    @section('main_content')
    {{ Form::open() }}
    <div class="form-group">
      <label for="email_field" class="control-label">Email Address:</label>
      {{ Form::text('email', null, array('id' => 'email_field', 'class' => 'form-control')) }}
    </div><!--form-group-->
    <div class="form-group">
      <label for="password_field" class="control-label">Password:</label>
      {{ Form::password('password', array('id' => 'password_field', 'class' => 'form-control')) }}
    </div><!--form-group-->
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div><!--col-->
</div><!--row-->
@stop
