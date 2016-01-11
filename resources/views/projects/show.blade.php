@extends('app')

@section('content')
	<h2>Project Name: {{$project->name}}</h2>
	<hr>
		<project>
			<div class="body">ID: {{$project->id}}</div>
		</project>
@stop