@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/data-tables/datatables.min.css') }}
	{{ HTML::style('vendor/plugins/font-awesome/css/font-awesome.css') }}	
	{{ HTML::style('vendor/plugins/datepicker/css/foundation-datepicker.min.css') }}
	{{ HTML::style('vendor/plugins/imgareaselect/imgareaselect-deprecated.css') }}
<style type="text/css" media="screen">
.dataTables_filter {
     display: none;
}
.button.formbutton {
	/*padding: 7px 30px 7px 30px;*/
	font-size: 23px;
}
</style>
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
					<h2 class="header-text not-selectable" unselectable="on">Recompensas</h2>			
				</div>
			</div>	
		</div>		
	</div>
	<div id="showRewards"  class="main-div content-body" style="padding-bottom: 40px; font-family: oswaldoregular;">
		<div class="row">
			<div class=" small-12 medium-12 medium-centered large-12 large-centered columns" style="background-color: white;">
				<div class="row">
					<div class="custom-panel-heading">
						Mis recompensas
					</div>
					<div hidden="true" class="success callout" tabindex="100" data-closable>
						<p class="message-alert"></p>
						<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>	
					<div style="float: left;"  class=" small-12 small-centered medium-12 medium-centered large-12 large-centered columns">					
						<div class="row margin-top-20">
							<div class="small-2 medium-2 large-1 columns left">
								<label for="middle-label" class="text-right  label-form">Buscar:</label>
							</div>
							<div class="small-3 medium-3 large-3columns left">
								<input class="input-form" id="searchbox" type="text" >
							</div>
							<div class="small 3 medium 3 large-3 right margin-right-15" >
								<input id="openNewReward" style="float: right;" type="submit" class="formbutton button"  value="Nueva recompensa">
							</div>
	 					</div>
						<table id="tblRedemp" class="display rewardstable" cellspacing="0" width="100%">
							<thead >
								<tr >
									<th>NOMBRE</th>
									<th>PUNTOS</th>
									<th>NO. REDENCIONES</th>
									<th>VIGENCIA</th>
									<th>OPCIONES</th>
								</tr>
							</thead>
							<tbody>
								@foreach($rewards AS $reward)
									<tr>
										<td>{{$reward->name}}</td>
										<td>{{$reward->points}}</td>
										<td>{{$reward->redemptionstotal}}</td>
										<td>{{$reward->vigency}}</td>
										<td>
											<span><a class="edtReward font-color-black"><i class="fa fa-pencil-square-o"></i>editar</a></span>
											<div class='divdata' hidden='true'>
												<data class='dataRewDesc'>{{$reward->description}}</data>
												<data class='dataRewTerms'>{{$reward->terms}}</data>
												<data class='dataRewImage'>{{$reward->image}}</data>
												<data class='dataRewList'>{{$reward->rewardlist}}</data>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End main div -->
	<div id="addReward" class="main-div content-body" style="padding-bottom: 40px; font-family: oswaldoregular;">
		<div class="row">
			<div class=" small-12 medium-12 medium-centered large-12 large-centered columns" style="background-color: white;">
				<div class="row">
					<div class="custom-panel-heading">
						Agregar recompensa
					</div>
					<div hidden="true" class="success callout" tabindex="100" data-closable>
						<p class="message-alert"></p>
						<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>	
					<div class="custom-panel-details small-12 medium-12 large-12 columns">
						<div class="row">
							<form data-abide id="addRewardForm" data-row="" class="standard-form">
								<div class="small-12 medium-6 large-3 columns">
									<label class="label-form">Nombre:
										<input maxlength="45" id="rewardName" required type="text" placeholder="Nombre">
											<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
									</label>
									<label class="label-form">Describe tu recompensa:
										<textarea maxlength="140" id="rewardDesc"  required type="text" cols="50" style="height: 160px" placeholder="Descripcion"></textarea>
										<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
									</label>	
								</div>
								<div class="small-12 medium-6 large-3 columns">
									<label class="label-form">Vigencia:
										<input type="text"  data-validator="check-date" id="rewardVig" required class="font-form" placeholder="DD/MM/AAAA">
										<span class="form-error" style="font-size: 20px;"> Campo requerido </span>						
									</label>
									<label class="label-form">Terminos y condiciones:
										<textarea maxlength="500" id="rewardtermns" required type="text" cols="50" style="height: 160px" placeholder="Terminos y condiciones"></textarea>
										<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
									</label>
								</div>
								<div class="small-middle reveal"  id="modal-reward" data-reveal>
									<div class="reveal-title">
										<h3 class="centerHeader">Edita tu imagen</h3>
									</div>
									<div class="reveal-body centerpic" >
										<img id="imgreward" class="imgStopMaxWidth" style="margin: 0 auto; display: block;" src=""/>
									</div>
									<div class="reveal-footer">
										<div class="row">
											<div class="small-12 medium-12 large-12 columns">
												<input id="saveReward" style="float: right;" type="submit" class="formbutton button"  value="Aceptar">
												<input id="closeModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
											</div>
										</div>	
									</div>	
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="small-12  medium-12  large-6  columns">
									<div class="row">
										<div class="small-12 medium-6 large-6 columns" style="text-align: center;">
											<label class="label-form">Tu imagen de recompensa:</label>
												<div class="drop-zone-recompensa">
													<img id="imgrewardtoshow" style="max-width:220px; max-height:165px;" src=""/>
													<input id="inputimgreward" type="hidden">
												</div>
											<label style="line-height: 1.2; font-size: 19px;">440X330</label>
											<label for="reward-upload" class="formbutton button ">Examinar</label>
											<input id="reward-upload"  type="file" name="reward-upload" class="show-for-sr">
											<span class="form-error pics small-12  medium-12  large-12 columns" style="font-size: 20px;"> La imagen es requerida </span>	
											<!-- The progress bar -->
											<div class="success progress allign-div-center" hidden style="width: 150px">
												<div id="rewardbar" class="progress-meter" style="width: 0%"></div>
											</div>									
										</div>
										<div class="small-12 medium-6 large-6 columns">
											<label class="label-form">Puntos:
												<input data-validator="check-only-interger"  id="rewardPoints"  required type="text" placeholder="Puntos"  >
												<span class="form-error" style="font-size: 20px;"> Campo requerido </span>								
											</label>
	  									</div>
									</div>
								</div>
							</form>
							<div class="custom-panel-footer small-12 medium-12 large-12 columns">
								<input id="addNewReward" style="float: right;" type="submit" class="formbutton button"  value="Almacenar">
								<input id="updateReward" style="float: right;" type="submit" class="formbutton button"  value="Actualizar">
								<input id="cancelReward" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Regresar">
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End add reward div -->
@stop
@section('addJs')
	{{HTML::script('js/rewards.js')}}
	{{HTML::script('/vendor/plugins/datepicker/js/foundation-datepicker.min.js')}}
	{{HTML::script('/vendor/plugins/datepicker/js/locales/foundation-datepicker.es.js')}}	
	{{HTML::script('/vendor/plugins/data-tables/datatables.min.js')}}
	{{HTML::script('vendor/plugins/canvasresize/canvasResize.js')}}
	{{HTML::script('vendor/plugins/canvasresize/canvas-to-blob.js')}}
	{{HTML::script('vendor/plugins/canvasresize/exif.js')}}
	{{HTML::script('vendor/plugins/canvasresize/binaryajax.js')}}
	{{HTML::script('vendor/plugins/imgareaselect/jquery.imgareaselect.min.js')}}
@stop
@stop