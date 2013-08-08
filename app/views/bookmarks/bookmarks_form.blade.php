@extends('layouts.master')

@section('html_head_content')
<title>{{ $edit ? 'Edit Bookmark' : 'Add Bookmark' }}</title>
@stop

@section('title_content')
<ul class="breadcrumb">
  <li><a href="{{ route('home') }}">Home</a></li>
  <li><a href="{{ route('bookmarks.index') }}">Bookmarks</a></li>
  <li class="active">{{ $edit ? 'Edit Bookmark' : 'Add Bookmark' }}</li>
</ul>
<div class="row">
  <div class="col-lg-4 col-offset-4">
    <h1>{{ $edit ? 'Edit Bookmark' : 'Add Bookmark' }}</h1>
    @stop

@section('main_content')
{{ Form::model($bookmark, array('route' => 'bookmarks.store')) }}

<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
  <label for="title" class="control-label">Title:</label>
  {{ Form::text('title', null, array('id' => 'title_field', 'class' => 'form-control')) }}
</div><!--form-group-->
<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
  <label for="url" class="control-label">URL:</label>
  {{ Form::text('url', null, array('id' => 'url_field', 'class' => 'form-control')) }}
</div><!--form-group-->
<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
  <label for="description" class="control-label">Description:</label>
  {{ Form::textarea('description', null, array('id' => 'description_field', 'class' => 'form-control')) }}
</div><!--form-group-->
<button type="submit" class="btn btn-primary">Save</button>

</form>
</div><!--col-->
</div><!--row-->
@stop
