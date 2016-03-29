@extends('template.main')
@section('content')
<div class="light-brown" style="padding-bottom: 30px">
	<div class="paddig-20" style=" background-image: url('vendor/img/nube.png'); background-repeat: no-repeat; background-size: 50% 100%;  background-color: #00BFF1;  " >
		<div class="row">
			<div class="large-12 columns" style="height: 130px; display: flex; align-items: center; justify-content: center;">
				<div class="large-4 columns">
					<img style="width: 110px; height: 110px; float: right;" class="divCircle" src="{{ $commerce->image }}" alt="logo" />
				</div>
				<div class="large-8 columns">
					<h2 class="my-font" style="line-height: 100px; padding-left: 50px; border-left: solid white; border-width: 0.06em; color: white;">BIENVENIDO {{ strtoupper($commerce->name) }}	</h2>				
				</div>
			</div>	
		</div>			
	</div>
	<div class="row" style="padding-top: 20px">
		<div class="large-10 large-centered columns">
			<div id="panelgraph" data-commerce='{{$commerce->id}}' chart-com="{{$chartcom}}" data-month="{{$month}}" class="large-4 columns newchart">
				<button style="font-size: 34px;" class="white button columns active-blue oswaldoregular" data-tab="#panel1v">AFILIADO POR MES</button>	
				<button style="font-size: 34px;" class="white button columns oswaldoregular" data-tab="#panel2v">VISITAS REGISTRADAS</button>	
				<button style="font-size: 34px;" class="white button columns oswaldoregular" data-tab="#panel3v">REDENCIONES POR MES</button>	
			</div>
			<div class="large-8 columns">					
				<div class="row">
					<div class="medium-5 medium large-5 large columns">
						<form>
							<select id='month-chart' class="medium-8 medium large-8 large columns">	
							@foreach(Helper::getArrayMonths() as $index => $month)
								<option value="{{$index}}">{{ $month }}</option>
							@endforeach
			  				</select>
						</form>
					</div>
				</div>
				<div style="border-color: #828181; border: 1px solid #4E0664; background-color: white;">
					<div id="porcents" class="large-12 large-centered columns" hidden="true" style="margin-top: 5px; margin-left: 15px">
							<div clas="row">
								<div class="grap-label large-2 columns" style="	background-color: #0F1B5E; display: table-cell; vertical-align: middle;">
									<p style="margin: 0; line-height: 1; text-align: center;">TOTAL MES ANTERIOR</p>
								</div>
								<div class="large-2 columns" style="">
									<p class="grap-porcent" id="lastMonthTotal"></p>
								</div>
								<div class="grap-label large-2 columns" style="	background-color: #0F1B5E; ">
									<p style="margin-top: 10px; margin-bottom: 10px; line-height: 1; text-align: justify;">CRECIMIENTO</p>
								</div>
								<div class="large-2 columns">
									<p class="grap-porcent" id="crecimiento"></p>
								</div>
								<div class="grap-label  large-2 columns" style="	background-color: #0F1B5E;">
									<p style="margin: 0; line-height: 1; text-align: center;">CRECIEMINTO RELATIVO</p>
								</div>
								<div class="large-2 columns">
									<p class="grap-porcent" id="creRelativo"></p>
								</div>					
							</div>
						</div>	
					<div class="tabs-panel is-active" id="panel1v">
					</div>
					<div class="tabs-panel" id="panel2v">
						<canvas id="canvasCheck" height="255"></canvas>
					</div>
					<div class="tabs-panel" id="panel3v">
						<canvas id="canvasCheck" height="255"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="large-10 large-centered columns">
			<div class="large-4 columns">
				<button class="button homebutton appbuttons columns">
					<img style="width: 35px; display:block; margin: auto; " src="vendor/home/recompensas.png" alt="recompensas">
					<p class="oswaldoregular" style="font-weight: bold; font-size: 33px; text-align: center; color: #0F1B5E; margin-bottom: 0px; margin-top: 10px">RECOMPENSAS</p>
					<p style="font-family: Helvetica; font-size: 12px; font-weight: 600;">Crea, consulta y administra aquí las recompensas a otorgar a tus clientes. Conoce además cuales han sido las mas populares para conocer así los gustos de tus afiliados.</p>
				</button>	
			</div>
			<div class="large-4 columns">
				<button id="reportes" class="button homebutton appbuttons  columns">
					<img style="width: 60px;  display:block; margin: auto;" src="vendor/home/reporte.png" alt="reporte">
					<p class="oswaldoregular" style="font-weight: bold; font-size: 33px; text-align: center; color: #0F1B5E; margin-bottom: 0px;  margin-top: 10px">REPORTE</p>
					<p style="font-family: Helvetica; font-size: 12px; font-weight: 600;">Consulta el comportamiento  de tu programa de lealtad a través de los resultados presentados por los reportes de nuestra plataforma. Verifica además tu crecimiento respecto a periodos anteriores.</p>
				</button>
			</div>
			<div class="large-4 columns">
				<button class="button homebutton appbuttons columns">
					<img style="width: 53px; display: block; margin: auto;" src="vendor/home/micomercio.png" alt="mi comercio">
					<p class="oswaldoregular" style="font-weight: bold; font-size: 33px; text-align: center; color: #0F1B5E; margin-bottom: 0px; margin-top: 10px">MI COMERCIO</p>
					<p style="font-family: Helvetica; font-size: 12px; font-weight: 600;">Configura toda la información de tu comercio en este módulo: Datos de contacto, logotipo, ubicación y más.</p>
				</button>
			</div>
		</div>
	</div>
</div>	
@stop
@section('addJs')
	{{HTML::script('js/home.js')}}
	{{HTML::script('/vendor/js/chart/Chart.min.js')}}
@stop