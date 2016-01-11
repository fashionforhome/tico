@extends('app')

@section('content')
<h1>Create New Project</h1>
<a href="{{ action('ProjectController@index')}}">Back to the Projects</a>

{!! Form::open(['action' =>'ProjectController@index']) !!}

	@include('projects.partials.form')
	@include('projects.partials.button', ['submitButtonText' => 'Add Project'])

{!! Form::close() !!}

@include('errors.list')

@stop