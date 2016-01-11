@extends('app')

@section('content')

<div class="tc">
	<div class="header">
		<img class="left" src="images/logo.gif" width="100"/>
		<h2>Folgende Tickets wurden bereits gedruckt, sollen sie erneut gedruckt werden?</h2>
	</div>

	{!! Form::open(['action' =>'IndexController@printAction']) !!}

	<ul class="list-group">
	@foreach ($doubledTickets as $doubledTicket)
		<li class="list-group-item">{{ $doubledTicket->getTicketName() }} - 
			
				{!! Form::checkbox('doubledTicket ' . $doubledTicket->id, $doubledTicket->getTicketName(), true); !!}
			
		</li>
	@endforeach

	{!! Form::textarea('tickets',$freshTicketIds,['class' => 'form-control hidden']) !!}
	{!! Form::text('project',$project,['class' => 'form-control hidden']) !!}

	</ul>
	<div class="form-group">
		{!! Form::submit('Print Tickets', null, ['class' => 'btn, btn-primary form-control']) !!}
	</div>
	{!! Form::close() !!}
	
</div>
@stop