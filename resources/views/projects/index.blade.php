@extends('app')

@section('content')
	<h1>Projects</h1>
	<p>
		<a href="{{ action('IndexController@index')}}">Back to TicketPrinter</a>
	</p>
	<hr>
	@foreach ($projects as $project)
		<h2>
			<a href="{{ action('ProjectController@edit', [$project->id])}}">{{$project->name}}</a>
		</h2>
	@endforeach
	
	{{--{!! Form::model($project,['method' =>'GET','action' => ['ProjectController@create']]) !!}--}}
    	{{--@include('projects.partials.button', ['submitButtonText' => 'Create new Project'])--}}
    {{--{!! Form::close() !!}--}}
    
    <p>
		<a href="{{ action('ProjectController@create')}}" class="btn btn-primary" role="button">Create new Project</a>
    </p>
@stop