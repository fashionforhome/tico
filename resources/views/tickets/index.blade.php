@extends('app')

@section('content')
	<h1>Tickets</h1>
	<hr>
	@foreach ($tickets as $ticket)
		<ticket>
			<h2>
				<a href="{{ action('TicketController@show', [$ticket->id])}}">{{$ticket->id}}</a>
			</h2>
			<h3>{{$ticket->project_id}}</h3>
		</ticket>
	@endforeach
@stop