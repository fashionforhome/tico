<!DOCTYPE html>
<html>
<head>
	<title>TiCo - Ticketconverter</title>

	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<!--	{!! HTML::style('css/main.css') !!}-->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	{!! HTML::style('assets/css/laravel.css') !!}
	{!! HTML::script('assets/js/app.min.js') !!}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	@yield('content')
</div>
</body>
</html>

