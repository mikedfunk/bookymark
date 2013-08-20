@extends('layouts.master')

@section('html_head_content')
<title>Reset Password</title>
@stop

@section('title_content')
<ul class="breadcrumb">
  <li><a href="{{ route('home') }}">Home</a></li>
  <li class="active">Reset Password</li>
</ul>
<div class="row">
  <div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
    <h1>Reset Password</h1>
    @stop

    @section('main_content')
    {{ Form::open() }}
    {{ Form::hidden('token', $token) }}

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
      <label for="email_field" class="control-label">Email Address:</label>
      {{ Form::text('email', Input::old('email'), array('id' => 'email_field', 'class' => 'form-control')) }}
      @if($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
      <label for="password_field" class="control-label">New Password:</label>
      <input type="password" name="password" class="form-control" id="password_field" />
      @if($errors->has('password')) <span class="help-block">{{ $errors->first('password') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
      <label for="password_confirmation_field" class="control-label">New Password Again:</label>
      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation_field" />
      @if($errors->has('password_confirmation')) <span class="help-block">{{ $errors->first('password_confirmation') }}</span> @endif
    </div><!--form-group-->

    <button type="submit" class="btn btn-primary">Reset Password</button>

  </form>
</div><!--col-->
    </div><!--row-->
    @stop
