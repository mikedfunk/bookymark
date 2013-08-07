@extends('layouts.master')

@section('html_head_content')
<title>Reset Password</title>
@stop

@section('title_content')
<div class="row">
  <div class="col-lg-4 col-offset-4">
    <h1>Reset Password</h1>
    @stop

    @section('main_content')
    {{ Form::open() }}
    {{ Form::hidden('token', $token) }}
    <div class="form-group">
      <label for="email_field" class="control-label">Email Address:</label>
      {{ Form::text('email', null, array('id' => 'email_field', 'class' => 'form-control')) }}
    </div><!--form-group-->
    <div class="form-group">
      <label for="password_field" class="control-label">New Password:</label>
      {{ Form::password('password', array('id' => 'password_field', 'class' => 'form-control')) }}
    </div><!--form-group-->
    <div class="form-group">
      <label for="password_confirmation_field" class="control-label">New Password Again:</label>
      {{ Form::password('password_confirmation', array('id' => 'password_confirmation_field', 'class' => 'form-control')) }}
    </div><!--form-group-->
    <button type="submit" class="btn btn-primary">Reset Password</button>
  </form>
</div><!--col-->
</div><!--row-->
@stop
