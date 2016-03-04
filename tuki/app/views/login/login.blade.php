<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>LOG IN</title>
		{{ HTML::style('vendor/css/foundation.min.css') }}
		<style>
			body {
				background-image: url('vendor/login/pattern.png');
			}
			footer{
				background-color: white;
			}
			.login-panel { 
				margin: 100px 0;
				padding: 40px 20px 0 20px;
			}
			.login-box{
				padding-top: 50px;
				background: #fff;
				border: 1px solid #ddd;
			}
			.logpic {
				float: left;
				margin: 20px;
			}
			.iconpic {
				margin-bottom: 10px;
				width: 220px;
			}
			.form-error {
				margin-bottom: 2px;
				margin-top: -16px
			}		
		</style>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	</head>

	<body>
		<header>
			<div class="large-3">
				<div class="row">
					<img class="logpic" src="vendor/login/logo.png" alt="logotuki" />		
				</div>
			</div>	
		</header>
		<div class="large-6 large-centered columns">
			<div class="login-panel">
				<div class="row">
					<div class="large-6 columns ">
						<img class="iconpic" src="vendor/login/icono.png" alt="tuki" />
					</div>	
					<div class="login-box large-6 columns">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<form id="login">														
							<div class="row">
								<div class="large-12 columns">
									<span class="form-error">Usuario o contraseña incorrectos</span>
									<input type="text" name="username" placeholder="Usuario" />
									<span class="form-error">Usuario requerido</span>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<input type="password" name="password" placeholder="Contraseña" />
									<span class="form-error">Contraseña requerida</span>
								</div>
							</div>						
							<div id="but_log">							
								<button class=" large-12 columns button expand">INICIAR SESIÓN</button>	
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
  		<script src="{{ URL::asset('vendor/js/foundation/jquery.min.js') }}"></script>		
  		<script src="{{ URL::asset('vendor/js/foundation/foundation.min.js') }}"></script>
  		<script type="text/javascript">
			var HOST = "{{URL::to('/')}}";
		</script>
  		<script src="{{ URL::asset('js/login/lgn.js') }}"></script>

	</body>
	<footer class="row">

	</footer>

</html>