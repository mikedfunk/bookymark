@extends('layouts.master')

@section('html_head_content')
<title>My Bookmarks</title>
@stop

@section('title_content')
<ul class="breadcrumb">
  <li><a href="{{ route('home') }}">Home</a></li>
  <li class="active">Bookmarks</li>
</ul>
<h1>
  <a href="{{ route('bookmarks.create') }}" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> New Bookmark</a>
  My Bookmarks
</h1>
@stop

@section('main_content')
@if($bookmarks->count())
<table class="table">
  <thead>
    <tr>
      <th>Title</th>
      <th>URL</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($bookmarks as $bookmark)
    <tr>
      <td>{{ $bookmark->title }}</td>
      <td>{{ $bookmark->url }}</td>
      <td class="text-right">
        <a href="{{ route('bookmarks.edit', $bookmark->id) }}" class="btn btn-xs btn-default btn-small"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
        <a href="{{ route('bookmarks.delete', $bookmark->id) }}" class="btn btn-xs btn-default btn_delete btn-small"><span class="glyphicon glyphicon-trash"></span> Delete</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $bookmarks->links() }}
@else
<div class="alert">No bookmarks found. Add one!</div>
@endif
@stop
