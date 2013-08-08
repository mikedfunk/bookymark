@extends('layouts.master')

@section('html_head_content')
<title>Request New Password</title>
@stop

@section('title_content')
<div class="row">
  <div class="col-lg-6 col-offset-3">
    <h1>Request New Password</h1>
    @stop

    @section('main_content')
    {{ Form::open() }}

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
      <label for="email_field" class="control-label">Email Address:</label>
      {{ Form::text('email', null, array('id' => 'email_field', 'class' => 'form-control')) }}
      @if($errors->has('email')) <span class="help-block">{{ $errors->first('email') }}</span> @endif
    </div><!--form-group-->

    <button type="submit" class="btn btn-primary">Send Reset Link</button>

  </form>
</div><!--col-->
</div><!--row-->
@stop
