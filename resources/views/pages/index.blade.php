@extends('app')


@section('content')
<div class="tc">
	<div class="header">
		<img class="left" src="images/logo.gif" width="100"/>

		<h2>F4H TicketConverter </h2>
	</div>
	@if(Session::has('flash_message'))
		<div class="alert alert-success">
			{{Session::get('flash_message')}}
		</div>
	@endif
	
	@if(Session::has('error_message'))
		<strong> {{ config('printer.errorMessage') }}</strong>
		<div class="alert alert-warning">
			{{Session::get('error_message')}}
		</div>
	@endif

	{!! Form::open(['action' =>'IndexController@confirmation', 'id' => 'id-input-form']) !!}

	{!! Form::select('project', $projects, $projects->first()) !!}

	<div class="form-group">
		{!! Form::label('tickets', 'Tickets:')!!}
		{!! Form::textarea('tickets',null,
		['class' => 'form-control', 
		'id' => 'id-field', 
		'placeholder' => 'Enter TicketIds e.g. 4933, 1854, 1439...']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Print Tickets', ['class' => 'btn, btn-primary form-control']) !!}
	</div>

	{!! Form::close() !!}
	
	<p>
    	<a href="{{ action('ProjectController@index')}}" class="btn btn-primary" role="button">Manage Projects</a>
    </p>
</div>
<script>
	jQuery('#id-field').keydown(function(event) {
		if(event.ctrlKey && event.keyCode == 13) {
		jQuery('#id-input-form').submit();
		}
	});
</script>
@stop

