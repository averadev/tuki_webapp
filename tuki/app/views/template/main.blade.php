<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		{{ HTML::style('vendor/css/foundation.min.css') }}
		{{ HTML::style('vendor/css/flaticons/flaticon.css') }}
		<style type="text/css">
		.flaticon-arrow::before{
			font-size: 15px !important;
			margin-left: 5px !important;
			line-height: 50%;
		}

		</style>
		<meta name="_token" content="{{ csrf_token() }}"/>
		<title> TUKI </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		@yield('addCss')	
	</head>
	<body>
		@include('template.header')
			<script src="{{ URL::asset('vendor/js/foundation/jquery.min.js') }}"></script>	
			<script src="{{ URL::asset('vendor/js/foundation/foundation.min.js') }}"></script>		
		@yield('addJs')
	</body>
</html>
