@extends('app')

@section('content')
	<h1>Ticket: {{$ticket->id}}</h1>
	<hr>
		<ticket>

			<div class="body">{{$ticket->project_id}}</div>
		</ticket>
@stop