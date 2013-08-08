@extends('layouts.master')

@section('html_head_content')
<title>My Profile</title>
@stop

@section('title_content')
<div class="row">
  <div class="col-lg-4 col-offset-4">
    <h1>My Profile</h1>
    @stop

    @section('main_content')
    {{ Form::model($user) }}

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
      <label for="email_field" class="control-label">Email Address:</label>
      {{ Form::text('email', null, array('id' => 'email_field', 'class' => 'form-control')) }}
      @if($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
      <label for="password_field" class="control-label">New Password:</label>
      <input type="password" name="password" class="form-control" id="password_field" />
      @if($errors->has('password')) <span class="help-block">{{ $errors->first('password') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
      <label for="confirm_password_field" class="control-label">Confirm New Password:</label>
      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation_field" />
      @if($errors->has('password_confirmation')) <span class="help-block">{{ $errors->first('password_confirmation') }}</span> @endif
    </div><!--form-group-->

    <button type="submit" class="btn btn-primary">Save</button>

  </form>
</div><!--col-->
</div><!--row-->
@stop
