<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>TUKI</title>
		{{ HTML::style('vendor/css/foundation.min.css') }}
		{{ HTML::style('css/your_style.css') }}
		<style>
			.login-box{
				padding-top: 0px;
				background: #fff;
				border: 3px solid #ddd;
			}
			.loginmaindiv{
				margin-top: 13%;
			}
			.form-error {
				font-size: 0.75rem !important;
				line-height: 1.5 !important;
				padding-bottom: 2px !important;
				margin-top: -15px;
				margin-bottom: -3px !important;
			}
			.showErrorCredentials{
				margin-top: 0px;
			}
	

			.button.home {
				padding:10px;
				background-color: #0F1B5E;
				color: white;
				font-weight: normal;
				font-family: oswaldoregular;
				font-size: 2em;
			}

			.button.home:hover{
				padding:10px;
				background-color: #070d2c;
				color: white;
				font-weight: normal;
				font-family: oswaldoregular;
			}

			.input-blue{
				border: 1px solid #00DAF7;
			}
			.input-blue:hover, .input-blue:focus {
				border: 1px solid #005a66;
			}
			.top-bar{
				padding-bottom: 0px;
				padding-top: 0px;
			}

			.tabs-title > a:focus, .tabs-title > a[aria-selected='true'] {
     			background: white; 
     		}
			body, html {
			   height: 85%;
			}
		</style>
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
		<link rel="shortcut icon" href="{{ URL::to('/') }}/vendor/img/favicon/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class="wrapper">
			<div class="small-12 small-centered medium-6 medium-centered large-4 large-centered columns loginmaindiv">

				<div class="small-12 medium-12 columns large-12 columns">
					<div class="login-box">
						<div class="row">
							<div style="text-align: center !important;" class="tabs-panel is-active" id="panel1v">
							<span hidden id="msgbox" style="font-size: 14px;" class="alert"> Su contraseña fue restablecida! </span>
								<form data-abide novalidate id="passform">	
								<input type="hidden" name="_token" value="{{$token}}" />													
									<div class="row">
										<div class="small-12 medium-12 large-12 columns">
										<label style="font-size: 20px; font-family:  Helvetica, Arial, sans-serif;">Recupere su contraseña </label>
											<input id="correo" class="input-blue" type="text"  placeholder="Ingrese su correo" required>
											<span style="margin-top: -14px;" style="" class="form-error">e-mail requerido</span>
										</div>
									</div>
									<div class="row">
										<div class="small-12 medium-12 large-12 columns">
											<input type="password" id="password" placeholder="Nueva contraseña" class="input-blue" required >
											<span style="margin-top: -14px;" class="form-error">Contraseña requerida</span>
										</div>
									</div>
									<div class="row">
										<div class="small-12 medium-12 large-12 columns">
											<input id="passconfirmed" type="password" placeholder="Confirme su contraseña" class="input-blue" data-equalto="password">
											<span style="margin-top: -14px;" class="form-error">Las contraseñas deben coincidir</span>
										</div>
									</div>																				
									<div>							
										<button id="changepass" style="text-align: center; font-size: 20px; font-family:  Helvetica, Arial, sans-serif;" class="small-12 medium-12 large-12 columns home button expand">ACTUALIZAR</button>
									</div>
								</form>	
							</div>
						</div>
					</div>
				</div>

			</div>
			<script src="{{ URL::asset('vendor/js/foundation/jquery.min.js') }}"></script>		
			<script src="{{ URL::asset('vendor/js/foundation/foundation.min.js') }}"></script>
			<script type="text/javascript">
					$(document).foundation();
					var HOST = "{{URL::to('/')}}";
			</script>  			
			<script src="{{ URL::asset('js/passwordreset/reminder.js') }}"></script>		
		</div>
	</body>
	<footer class="row">

	</footer>

</html>