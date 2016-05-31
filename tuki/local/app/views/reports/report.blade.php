@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/datepicker/css/foundation-datepicker.min.css') }}
	{{ HTML::style('vendor/plugins/font-awesome/css/font-awesome.css') }}
	{{ HTML::style('vendor/plugins/zurb-responsive-tables/responsive-tables.css') }}
@stop
@section('content')
	<div style=" background-image: url('vendor/img/nube.png'); background-repeat: no-repeat; background-size: 50% 100%;  background-color: #00BFF1;  " >
		<div class="row">
			<div class="medium-11 large-11 large-centered columns" style="height: 130px; display: flex; align-items: center; padding: 0px; justify-content: center;">
				<div class="medium-4 large-4 large-centered columns ">
					<div class="row">
						<a href="{{URL::to('/')}}">
							<img class="goback-bar" src="vendor/img/volver.png" alt="logo" />
						</a>
					</div>
				</div>
				<div class="medium-8 large-8 large-centered columns">
					<div class="row">
						<h2 class="header-text not-selectable" unselectable="on">REPORTES</h2>
					</div>			
				</div>
			</div>	
		</div>		
	</div>
<div class="main-div" style="padding-bottom: 40px; font-family: oswaldoregular;">
	<div class="row">
		<div class="container small-12 small-centered medium-12 medium-centered  large-12 large-centered columns" style=" background-color: white;">
			<div class="row">				
				<div class="small-12 medium-12 medium-centered large-12 large-centered columns form-report" style="float: right;">
					<form id="form-export">
						<div class="small-12 medium-5 medium-centered large-5 large-centered columns end">
							<div class="row">
								<div class="input-group">
									<span class="input-group-label"><i class="icon-iconreporte"></i></span>
									{{	Form::select('', array(
									'01' => 'REPORTE DE ACTIVIDADES',
									'02' => 'REPORTE DE AFILIACIONES Y VISITAS',
									'03'=>'REPORTE DE REDENCIONES'), '', 
									array('id' => 'sel-report','class'=>'select-primary input-group-field') ) }}
								</div>
							</div>
						</div>		

						<div class="small-12 medium-5 medium-centered large-5 large-centered columns end">
							<div class="row">	
								<div class="medium-1 large-1 columns">
									<div class="row">
										<label  style="font-size: 1.5rem; text-align: left;">Periodo:</label>
									</div>
								</div>
								<div class="medium-11 large-11 columns" style="padding-left: 50px;">
									<div class="row">
										<div class="medium-5 large-5 columns">
											<div class="row">
												<div class="input-group">
													<span class="input-group-label"><i class="fa fa-calendar"></i></span>
													{{ Form::text('','', array('class' => 'font-form input-group-field','id'=>'dp1','placeholder'=>'DD/MM/AAAA')) }}
												</div>
												<span class="form-error">
													<p style="font-size: 20px; line-height: 0;">Fecha requerida</p>	
												</span>
											</div>
										</div>
										<div class="medium-2 large-2 columns">
											<div class="row">
												<label  style="font-size: 1.5rem; text-align: center;">Y</label>
											</div>
										</div>
										<div class="medium-5 large-5 columns">
											<div class="row">
												<div class="input-group">
													<span class="input-group-label"><i class="fa fa-calendar"></i></span>
													{{ Form::text('','', array('class' => 'font-form input-group-field','id'=>'dp2','placeholder'=>'DD/MM/AAAA')) }}
												</div>
												<span class="form-error">
													<p style="font-size: 20px; line-height: 0;">Fecha requerida</p>	
												</span>
											</div>								
										</div>
									</div>
								</div>	
							</div>	
						</div>			
						<input type="submit" id="submit-form" hidden="true" />
					</form>
				</div>
				<div class="medium-12 medium-centered large-12 large-centered columns footer-form" >					
					<button id="cleanreport" class="secundary button medium-2 medium-centered large-2 large-centered columns">LIMPIAR</button>					
					<button id="make-report" type="subtmit" class="default button medium-2 medium-centered large-2 large-centered columns " style="margin-left: 100px;">CONSULTAR</button>					
				</div>			
			</div>	
		</div>
		<div id="reportDetails" hidden class="container small-12 small-centered medium-12 medium-centered larger-12 large-centered columns" style="background-color: white;">
			<div id="divCompare" hidden class="small-12 small-centered medium-12 medium-centered larger-12 large-centered columns">
				<div class="row">
					<h6 style="text-align: center; font-family:oswaldoregular; padding-left: 15px; font-size: 25px;" id="lastPeriodo"></h6>				
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Afiliaciones</span>
								<i class="fa fa-user-plus"></i>
							</div>
							<div class="stats-title">
								<span>Periodo seleccionado</span> 
							</div>
							<div class="stats-body">
								<span id="afiPeriodo"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Afiliaciones</span>
								<i class="fa fa-user-plus"></i>
							</div>
							<div class="stats-title">
								<span>Periodo anterior</span> 
							</div>
							<div class="stats-body">
								<span id="afiLastPeriodo"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span style="padding-right: 20px; padding-left: 25px;">Visitas</span>
								<i class="fa fa-users"></i>
							</div>
							<div class="stats-title">
								<span>Periodo seleccionado</span> 
							</div>
							<div class="stats-body">
								<span id="visiPeriodo"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span style="padding-right: 20px; padding-left: 25px;">Visitas</span>
								<span><i class="fa fa-users"></i></span>
							</div>
							<div class="stats-title">
								<span>Periodo anterior</span> 
							</div>
							<div class="stats-body">
								<span id="visiLastPeriodo"></span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Crecimiento</span>
								<i class="fa fa-bar-chart"></i>
							</div>
							<div class="stats-title">
								<span>Afiliaciones vs P.A.</span> 
							</div>
							<div class="stats-body">
								<span id="crecAfi"></span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-2 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Crecimiento</span>
								<i class="fa fa-bar-chart"></i>
							</div>
							<div class="stats-title">
								<span>Visitas vs P.A.</span> 
							</div>
							<div class="stats-body">
								<span id="crecvisi"> </span> 
							</div>
						</div>
					</div>

				</div>
			</div>
			<div id="tableActiv" hidden class="small-12 small-centered medium-9 medium-centered larger-6 large-centered columns">
				<div class="row">			
					<div class="small-4 medium-3 large-3 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span style="padding-right: 20px; padding-left: 25px;">Visitas</span>
								<i class="fa fa-users"></i>
							</div>
							<div class="stats-title">
								<span>Periodo seleccionado</span> 
							</div>
							<div class="stats-body">
								<span id="totalCheckInsPeriod"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-3 large-3 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Afiliaciones</span>
								<i class="fa fa-user-plus"></i>
							</div>
							<div class="stats-title">
								<span>Periodo seleccionado</span> 
							</div>
							<div class="stats-body">
								<span id="newClientesPeriod"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-3 large-3 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Recompensas</span>
								<i class="fa fa-shopping-bag"></i>
							</div>
							<div class="stats-title">
								<span>Por visita</span> 
							</div>
							<div class="stats-body">
								<span id="recVisitPeriod"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-3 large-3 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span style="padding-right: 20px; padding-left: 25px;">Visitas</span>
								<i class="fa fa-users"></i>
							</div>
							<div class="stats-title">
								<span>Promedio por cliente</span> 
							</div>
							<div class="stats-body">
								<span id="avgVisitClient"> </span> 
							</div>
						</div>
					</div>					
				</div>
			</div>			
			<div id="tableRedemptions" hidden class="small-12 small-centered medium-8 medium-centered larger-6 large-centered columns">
				<div class="row">
					<h6 style="text-align: center; font-family:oswaldoregular; padding-left: 15px; font-size: 25px;" id="lastPeriodRedemptions"></h6>				
					<div class="small-4 medium-4 large-4 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Redenciones</span>
								<i class="fa fa-shopping-bag"></i>
							</div>
							<div class="stats-title">
								<span>Periodo seleccionado</span> 
							</div>
							<div class="stats-body">
								<span id="redempPeriodo"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-4 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Redenciones</span>
								<i class="fa fa-shopping-bag"></i>
							</div>
							<div class="stats-title">
								<span>Periodo anterior</span> 
							</div>
							<div class="stats-body">
								<span id="lastPeriodRemdemp"> </span> 
							</div>
						</div>
					</div>
					<div class="small-4 medium-4 large-4 columns resultTables">
						<div class="stats">
							<div class="stats-header">
								<span>Crecimiento</span>
								<i class="fa fa-bar-chart"></i>
							</div>
							<div class="stats-title">
								<span>Redenciones vs P.A.</span> 
							</div>
							<div class="stats-body">
								<span id="crecRedemp"> </span> 
							</div>
						</div>
					</div>
				</div>
			</div>
			<div hidden id="reportToExport" class="small-12 small-centered medium-12 medium-centered columns larger-12 large-centered" style="min-height: 100px;">
			</div>	
			<div id="exportExcel" class="small-12 small-centered medium-12 medium-centered larger-12 large-centered columns" style="text-align: center; padding-top: 15px;">			
				{{ Form::open(array('url' => 'reportes/make-excel','method' => 'get','id'=>'form-export-excel')) }}
					<input name="reportType" type="hidden">
					<input name="startDate" type="hidden">
					<input name="endDate" type="hidden">
					<div  id="divSubmitExcel" class="small-12 small-centered medium-12 medium-centered larger-12 large-centered end columns" hidden="true">
						<input type="submit" class="default button small-12 small-centered medium-2 medium-centered large-2 large-centered columns" value="Exportar">
					</div>
				{{ Form::close() }}				
			</div>
		</div>
	</div>	
</div> <!--end main div -->
@stop
@section('addJs')
	{{HTML::script('js/report.js')}}
	{{HTML::script('/vendor/plugins/datepicker/js/foundation-datepicker.min.js')}}
	{{HTML::script('/vendor/plugins/datepicker/js/locales/foundation-datepicker.es.js')}}
	{{HTML::script('/vendor/plugins/zurb-responsive-tables/responsive-tables.js')}}
	{{HTML::script('/vendor/plugins/pagination/paging.js')}}
	{{HTML::script('/vendor/plugins/pagination/jquery-ui.min.js')}}
@stop