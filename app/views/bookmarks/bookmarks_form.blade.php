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
  <div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
    <h1>{{ $edit ? 'Edit Bookmark' : 'Add Bookmark' }}</h1>
    @stop

    @section('main_content')
    @if($edit)
    {{ Form::model($bookmark, array('route' => array('bookmarks.update', $bookmark->id), 'method' => 'put')) }}
    @else
    {{ Form::model($bookmark, array('route' => 'bookmarks.store')) }}
    @endif

    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
      <label for="title" class="control-label">Title:</label>
      {{ Form::text('title', null, array('id' => 'title_field', 'class' => 'form-control')) }}
      @if($errors->has('title')) <span class="help-block">{{ $errors->first('title') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
      <label for="url" class="control-label">URL:</label>
      {{ Form::text('url', null, array('id' => 'url_field', 'class' => 'form-control')) }}
      @if($errors->has('url')) <span class="help-block">{{ $errors->first('url') }}</span> @endif
    </div><!--form-group-->

    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
      <label for="description" class="control-label">Description:</label>
      {{ Form::textarea('description', null, array('id' => 'description_field', 'class' => 'form-control')) }}
      @if($errors->has('description')) <span class="help-block">{{ $errors->first('description') }}</span> @endif
    </div><!--form-group-->

    <button type="submit" class="btn btn-primary">Save</button>

  </form>
</div><!--col-->
    </div><!--row-->
    @stop
