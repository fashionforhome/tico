@extends('app')

@section('content')
	<h1>Project:  {!! $project->name !!}</h1>

{!! Form::model($project,['method' =>'Patch','action' => ['ProjectController@update', $project->id]]) !!}

	@include('projects.partials.form')
	@include('projects.partials.button', ['submitButtonText' => 'Update Project'])

{!! Form::close() !!}

{!! Form::model($project,['method' =>'DELETE','action' => ['ProjectController@destroy', $project->id]]) !!}
	@include('projects.partials.button', ['submitButtonText' => 'Delete Project'])
{!! Form::close() !!}

	@include('errors.list')
@stop