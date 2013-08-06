@extends('layouts.master')

@section('html_head_content')
<title>Register</title>
@stop

@section('title_content')
<div class="row">
  <div class="col-lg-4 col-offset-4">
    <h1>Register</h1>
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
<div class="form-group">
  <label for="confirm_password_field" class="control-label">Confirm Password:</label>
  {{ Form::password('password_confirmation', array('id' => 'confirm_password_field', 'class' => 'form-control')) }}
</div><!--form-group-->
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div><!--col-->
</div><!--row-->
@stop
