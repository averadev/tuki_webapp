<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		{{ HTML::style('vendor/css/foundation.min.css') }}
		{{ HTML::style('vendor/css/flaticons/flaticon.css') }}
		{{ HTML::style('css/your_style.css') }}
		@yield('addCss')
		<style type="text/css">
		.flaticon-arrow::before{
			font-size: 15px !important;
			margin-left: 5px !important;
			line-height: 50%;
		}
		#div-datepicker-div { font-size:11px; }
		 @font-face{
			font-family: 'oswaldoregular';
			src: url('vendor/fonts/denseregular.ttf')  format('truetype'),
			url('vendor/fonts/denseregular.woff') format('woff'),
			url('vendor/fonts/denseregular.eot') ; /* IE9 Compat Modes */
		}
  		@font-face{
			font-family: 'helveticaneuel';
			src: url('vendor/fonts/helveticaneuel.ttf')  format('truetype'),
			url('vendor/fonts/helveticaneuel.woff') format('woff'), 
			url('vendor/fonts/helveticaneuel.eot'); /* IE9 Compat Modes */
		}

		.oswaldoregular{
			font-family: oswaldoregular; 
		}
		.my-font{
			font-family: helveticaneuel;
		}
		</style>
		<meta name="_token" content="{{ csrf_token() }}"/>
		<title> TUKI </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="{{ URL::to('/') }}/vendor/img/favicon/favicon.ico" type="image/x-icon">
		@yield('addCss')	
	</head>
	<body>
		@include('template.header')
		@yield('content')
			<script src="{{ URL::asset('vendor/js/foundation/jquery.min.js') }}"></script>	
			<script src="{{ URL::asset('vendor/js/foundation/foundation.min.js') }}"></script>
			<script type="text/javascript">
				    $(document).foundation();
				    var HOST = "{{URL::to('/')}}";
			</script>
		{{HTML::script('js/global.js')}}
		@yield('addJs')
	</body>
</html>
