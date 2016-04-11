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
						<div class="small-12 medium-12 medium-centered large-12 large-centered columns">
							<div class="row">
								<div class="input-group">
									<span class="input-group-label"><i><img src="vendor/img/iconreporte.png"/></i></span>
									{{	Form::select('', array(
									'01' => 'REPORTE DE ACTIVIDADES',
									'02' => 'REPORTE DE AFILIACIONES Y VISITAS',
									'03'=>'REPORTE DE REDENCIONES'), '', 
									array('id' => 'sel-report','class'=>'select-primary input-group-field') ) }}
								</div>
							</div>
						</div>			
						<div class="small-12 medium-12 medium-centered large-10 large-centered columns">
							<div class="medium-3 large-3 columns">
								<label  style="font-size: 1.5rem; text-align: center;">Periodo:</label>
							</div>
							<div class="medium-3 large-3 columns">
								<div class="input-group">
									<span class="input-group-label"><i class="fa fa-calendar"></i></span>
									{{ Form::text('','', array('class' => 'font-form input-group-field','id'=>'dp1','placeholder'=>'DD/MM/AAAA')) }}
								</div>
								<span class="form-error">
									<p style="font-size: 20px; line-height: 0;">Fecha requerida</p>	
								</span>
							</div>
							<div class="medium-2 large-1 columns">
								<label  style="font-size: 1.5rem; text-align: center;">Y</label>
							</div>
							<div class="medium-3 large-3 columns end">
								<div class="input-group">
									<span class="input-group-label"><i class="fa fa-calendar"></i></span>
									{{ Form::text('','', array('class' => 'font-form input-group-field','id'=>'dp2','placeholder'=>'DD/MM/AAAA')) }}
								</div>
								<span class="form-error">
									<p style="font-size: 20px; line-height: 0;">Fecha requerida</p>	
								</span>								
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
		<div class="container small-12 small-centered medium-12 medium-centered columns larger-12 large-centered" style="background-color: white;">
			<div class="small-12 small-centered medium-12 medium-centered columns larger-12 large-centered">
				<div id="divCompare"  class="medium-12 medium-centered large-12 large-centered columns" hidden="true">	  
					<h6 style="text-align: center; font-family:oswaldoregular; font-size: 25px;" id="lastPeriodo"></h6>
					<table  class="responsive table tableComp table-bordered table-striped">
						<tr>
							<td>
								Afiliaciones periodo seleccionado:
							</td>
							<td>
								<label id="afiPeriodo"></label>
							</td>
							<td>
								Visitas periodo seleccionado:
							</td>
							<td>
								<label id="visiPeriodo"></label>
							</td>
						</tr>
						<tr>
						  <td>
						  	 Afiliaciones periodo anterior:
						  </td>
						  <td>
							<label id="afiLastPeriodo"></label>
						  </td>
						  <td>
						  	 Visitas periodo anterior:
						  </td>
						  <td>
						 		<label id="visiLastPeriodo"></label>
						  </td>
						</tr>
						<tr>
						  <td>
							  Crecimiento afiliaciones vs periodo anteior:
						  </td>
						  <td>
								<label id="crecAfi"></label>
						  </td>
						  <td>
							  Crecimiento visitas vs periodo anteior:
						  </td>
						  <td>
							   <label id="crecvisi"></label>
						  </td>									  
						</tr>
					</table>
				</div>
			</div>
			<div id="tableRedemptions" class="medium-12 medium-centered large-12 large-centered columns" hidden="true">
				<h6 style="text-align: center; font-family:oswaldoregular; margin-right: 20px; font-size: 25px;" id="lastPeriodRedemptions"></h6>
				<table  class="responsive table tableRedemp table-bordered table-striped">
					<tr>
						<td>
							Redenciones periodo seleccionado:
						</td>
						<td>
							<label id="redempPeriodo"></label>
						</td>
					</tr>
					<tr>
						<td>
							Redenciones periodo anterior:
						</td>
						<td>
							<label id="lastPeriodRemdemp"></label>
						</td>
					</tr>
					<tr>
						<td>
							Crecimiento vs periodo anterior:
						</td>
						<td>
							<label id="crecRedemp"></label>
						</td>
					</tr>								
				</table>
			</div>
			<div id="tableActiv" class="medium-12 medium-centered large-12 large-centered columns" hidden="true">
				<table  class="responsive table tableRedemp table-bordered table-striped">
					<tr>
						<td>
							Total de visitas registradas:
						</td>
						<td>
							<label id="totalCheckInsPeriod"></label>
						</td>
					</tr>
					<tr>
						<td>
							Total de nuevos clientes:
						</td>
						<td>
							<label id="newClientesPeriod"></label>
						</td>
					</tr>
					<tr>
						<td>
							Recompensas por visitas:
						</td>
						<td>
							<label id="recVisitPeriod"></label>
						</td>
					</tr>
					<tr>
						<td>
							Visitas promedio por cliente:
						</td>
						<td>
							<label id="avgVisitClient"></label>
						</td>
					</tr>												
				</table>
			</div>
			<div id="reportToExport" class="small-12 small-centered medium-12 medium-centered columns larger-12 large-centered" style="min-height: 400px;">
			</div>	
			<div id="exportExcel" class="small-12 small-centered medium-12 medium-centered larger-12 large-centered columns" style="text-align: center;">
			
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

