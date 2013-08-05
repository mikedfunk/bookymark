@extends('layouts.master')

@section('head_content')
<title>Login</title>
@stop

@section('main_content')
<h1>Please Login</h1>
{{ Form::open() }}
<label for="email_field">Email Address:</label>
{{ Form::text('email', null, array('id' => 'email_field')) }}
<label for="password_field">Password:</label>
{{ Form::password('password', array('id' => 'password_field')) }}
<button type="submit">Submit</button>
</form>
@stop
