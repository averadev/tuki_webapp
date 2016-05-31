<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title>LOG IN</title>
		{{ HTML::style('vendor/css/foundation.min.css') }}
		{{ HTML::style('css/your_style.css') }}
		<style>
			.body-home {
				background-image: url('vendor/login/pattern.png');
			}
			.login-box{
				padding-top: 0px;
				background: #fff;
				border: 1px solid #ddd;
			}
			.loginmaindiv{
				margin-top: 13%;
			}
			.iconpic {
				     width: auto;
    				height: auto;
    				margin: 0 auto;
    				display: block;
    				padding-bottom: 30px;

			}
			.showErrorCredentials{
				margin-top: 12px;
			}
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

			.logom{
				width: 26%;
    			height: auto;
    			padding-left: 17px;
    			padding-right: 17px;
    			padding-top: 5px;
    			padding-bottom: 5px;
      			border-right: 1px solid #DFDFDF;
    			border-left: 1px solid #DFDFDF;
			}

			@media screen and (max-width: 39.9375em) {
				.logom{
					width: 100%;
				}
			}

			.tabs{
			 margin: 0;
			 padding: 0;
			 padding-bottom: 10px;
			}
			.tabs li{
				margin: 0;
				padding: 0;			
			}
			.tabs li>a{
				line-height: 1.2;
				color: #7C7C7C;
				text-align: center;
				display: flex; 
				align-items: center; 
				justify-content: center;
				height: 20px;
				background-color: #e6e6e6;
				font-family: helveticaneuel;
			}

			.tabs-title>a {
				font-size: 1em;
			}
			.wrapper{            
               width:100%;
               margin:auto;
			}

			.tabs-content {
				border: none;
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

		</style>
		<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
		<link rel="shortcut icon" href="{{ URL::to('/') }}/vendor/img/favicon/favicon.ico" type="image/x-icon">
	</head>
	<body class="body-home">

		<div class="wrapper">
			<header>
				<div class="top-bar white-color">
					<div  class="small-5 small-centered medium-10 medium-centered large-5 large-centered columns" style="background-color: white;">
						<div class="row">
							<img class="left logom" src="vendor/login/logo.png" alt="logotuki" />		
						</div>
					</div>
				</div>	
			</header>
			<div class="small-12 small-centered medium-12 medium-centered large-6 large-centered columns loginmaindiv">
					<div class="row">
						<div class="small-8 small-centered medium-5 medium-uncentered large-5 large-uncentered columns "> <!--div icono tuki -->
						
								<img style="" class="iconpic" src="vendor/login/icono.png" alt="tuki" />
						
						</div>
						<div  class="login-box small-12 medium-6 large-6 columns right">
							<div class="row">
								<div class="small-12 medium-12 columns large-12 columns">
									<div class="row">								
										<div>
											<ul class="tabs small-12 medium-12 large-12 columns" id="example-tabs" data-tabs>
												<li  class="tests small-6 medium-6 large-6 columns tabs-title is-active"><a href="#panel1v" aria-selected="true">LOG IN</a></li>
												<li class="tests small-6 medium-6 large-6 columns tabs-title"><a href="#panel2v">¿OLVIDASTE TU CONTRASEÑA?</a></li>
											</ul>
										</div>
										<div>
											<div class="tabs-content" data-tabs-content="example-tabs">
												<div class="tabs-panel is-active" id="panel1v">
													<input type="hidden" name="_token" value="{{ csrf_token() }}" />
													<form id="login">														
														<div class="row">
															<div class="small-12 medium-12 large-12 columns">
																<span class="form-error showErrorCredentials">Usuario o contraseña incorrectos</span>
																<input class="input-blue" type="text" name="username" placeholder="Usuario" />
																<span  class="form-error">Usuario requerido</span>
															</div>
														</div>
														<div class="row">
															<div class="small-12 medium-12 large-12 columns">
																<input class="input-blue" type="password" name="password" placeholder="Contraseña" />
																<span class="form-error">Contraseña requerida</span>
															</div>
														</div>						
														<div id="but_log">							
															<button class="small-12 medium-12 large-12 columns home button expand">INICIAR SESIÓN</button>
														</div>
													</form>	
												</div>
												<div class="tabs-panel" id="panel2v">
													<form data-abide id="recovery">
														<span class="form-error showErrorCredentials"></span>
													 	<label class="label-form">Ingrese su correo:</label>
													 	<input id="emailrecover" class="input-blue" type="text" pattern="valemail" required placeholder="usuario@ejemplo.com" />											 	
													 	<button id="resetpass" class="small-12 medium-12 large-12 columns home button expand">Enviar</button>
													</form>
												</div>
											</div>
										</div>
									</div>
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
		  	<script src="{{ URL::asset('js/login/lgn.js') }}"></script>
		</div>

	</body>
	<footer class="row">

	</footer>

</html>