@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/colorpicker/jquery.simplecolorpicker.css') }}
	{{ HTML::style('vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.css') }}
	{{ HTML::style('vendor/plugins/imgareaselect/imgareaselect-deprecated.css') }}
	{{ HTML::style('vendor/plugins/font-awesome/css/font-awesome.css') }}
	{{ HTML::style('vendor/plugins/data-tables/datatables.min.css') }}
	{{ HTML::style('vendor/plugins/messagemodal/css/jquery.modal.css') }}	
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
					<h2 class="header-text not-selectable" unselectable="on">MI COMERCIO</h2>
				</div>
			</div>	
		</div>		
	</div>
<div class="main-div content-body" style="padding-bottom: 40px; font-family: oswaldoregular;">
	<div class="row">
		<div class=" small-12 medium-12 large-12 columns" style="background-color: white;">
			<div class="row">
				<div class="custom-panel-heading">
				 	Configuración de mi comercio
				</div>
				<div hidden="true" class="success callout" tabindex="100" data-closable>
					<p class="message-alert"></p>
					<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="custom-panel-details small-12 medium-12 large-12 columns">
					<form data-abide id="addCommerce"  class="standard-form">
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Nombre de tu comercio:
									<input maxlength="50" data-validator="max50char" id="commerceName" required type="text" value="{{$commerce->comeName}}" placeholder="Nombre"  >
									<span class="form-error"> Campo requerido </span>
								</label>
								<label class="label-form">Slogan:
									<input maxlength="50" data-validator="max50char" id="commerceSlogan" required type="text" value="{{$commerce->description}}" placeholder="Slogan"  >
									<span class="form-error"> Campo requerido </span>
								</label>
								<label class="label-form">Describe tu comercio en 50 palabras o menos:
									<textarea id="descriptionCom" maxlength="500" data-validator="max500char" required type="text" cols="100" style="height: 100px" placeholder="Descripcion">{{$commerce->detail}}</textarea>
									<span class="form-error"> Campo requerido </span>
								</label>
							</div>
							<div class="small-12  medium-6  large-6  columns">
								<div class="row">
									<div class="reveal" id="modal-logo" data-reveal>
										<div class="reveal-title">
											<h3 class="centerHeader">Edita tu logotipo</h3>
										</div>
										<div class="reveal-body centerpic">
											<img id="imglogo" class="imgStopMaxWidth" style="margin: 0 auto; display: block;" src=""/>
										</div>
										<div class="reveal-footer">
											<div class="row">	
												<div class="small-12 medium-12 large-12 columns">
													<input id="saveLogo" style="float: right; margin-right: 18px;" type="submit" class="formbutton button"  value="Aceptar">
													<input id="dismissModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
												</div>
											</div>	
										</div>	
										<button class="close-button" data-close aria-label="Close modal" type="button">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="reveal" id="modal-portada" data-reveal>
										<div class="reveal-title">
											<h3>Edita tu Portada</h3>
										</div>
										<div class="reveal-body centerpic">	
											<img id="imgportada" class="imgStopMaxWidth" style="margin: 0 auto; display: block;" src=""/>
										</div>
										<div class="reveal-footer">
											<div class="row">
												<div class="small-12 medium-12 large-12 columns">
													<input id="savePortada" style="float: right;" type="submit" class="formbutton button"  value="Aceptar">
													<input id="closeModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
												</div>
											</div>
										</div>
										<button class="close-button" data-close aria-label="Close modal" type="button">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="small-12 medium-6 large-6 columns">
										<label class="label-form">Tu imagen de logotipo:</label>
											<div class="logo-zone drop-zone-logotipo">
												<img id="imglogotoshow" src="api/assets/img/api/commerce/{{$commerce->image}}"/>
												<input id="logo" type="hidden">
											</div>
										<label style="padding-left: 50px; line-height: 1.2; font-size: 19px;">200X200</label>
										<label for="fileupload" class="formbutton button ">Examinar</label>
										<input id="fileupload"  type="file" name="logo-upload" class="show-for-sr">
										<span class="form-error pics" style="font-size: 20px;"> El logotipo es requerido </span>	
										<!-- The progress bar -->
										<div class="success progress logo" hidden style="width: 150px">
											<div id="logobar" class="progress-meter" style="width: 0%"></div>
										</div>									
									</div>
									<div class="small-12 medium-6 large-6 large columns">
										<label class="label-form">Tu imagen de portada: </label>	
											<div class="drop-zone-portada">
												<img id="imgportadatoshow" src="api/assets/img/api/commerce/{{$commerce->banner}}"/>
												<input id="portada" type="hidden">
											</div>
										<label style="padding-left: 90px; line-height: 1.2; font-size: 19px;">440X280</label>		
										<label for="portada-upload" class="formbutton button ">Examinar</label>
										<input id="portada-upload" type="file" name="portada-upload" class="show-for-sr">
										<span class="form-error pics" style="font-size: 20px;"> La portada es requerida </span>
										<!-- The progress bar -->
										<div class="success progress portada" hidden style="width: 150px;">
											<div id="portadabar" class="progress-meter" style="width: 0%"></div>
										</div>
									</div>
  									<div class="small-12 medium-6 large-6 columns">
  										<label class="label-form ">Color para identificar a tu comercio:</label>								
  									</div>
  									<div class="small-12 medium-6 large-6 columns">	
  										<select name="colorpicker-picker-longlist">
  										@foreach ($paletteColors as $key => $value)
  											@if($value->code == $colorCommerce)
  											<option selected data-color="{{$value->id}}" value="{{$value->code}}">{{$value->name}}</option>
  											@else
  											<option data-color="{{$value->id}}" value="{{$value->code}}">{{$value->name}}</option>
  											@endif
  										@endforeach
										</select>
  									</div>
  								</div>
  							</div>
						</div>
						<h4 style="float: left;" class="myfont small-12  medium-12  large-12 ">Datos de contacto</h4>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Página web:
									<input id="webCom" maxlength="100" data-validator="max100char" type="text" value="{{$commerce->web}}" placeholder="Página web">
									<span class="form-error"></span>
								</label>
							</div>
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Facebook:
									<input id="facebook" maxlength="150" data-validator="max150char" value="{{$commerce->facebook}}" type="text" placeholder="Facebook">
									<span class="form-error"></span>
								</label>
							</div>							
						</div>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Twitter:
									<input id="twitter" maxlength="150" data-validator="max150char" type="text" value="{{$commerce->twitter}}" placeholder="Twitter">
									<span class="form-error"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<!-- upload gallery -->
							<div class="small-12 medium-6 large-6 columns">
								<h4 class="myfont">Crea tu galeria</h4>
								<div class="reveal" id="modal-gallery" data-reveal>
									<div class="reveal-title">
										<h3>Edita tu imagen</h3>
									</div>
									<div class="reveal-body centerpic">
										<img id="imggallery" class="imgStopMaxWidth" style="margin: 0 auto; display: block;" src=""/>
									</div>									
									<div class="reveal-footer">
										<div class="row">
											<div class="small-12 medium-12 large-12 columns">
												<input id="savefotoGalery" style="float: right; margin-right: 18px;" type="submit" class="formbutton button"  value="Aceptar">
												<input id="hidemodal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
											</div>
										</div>
									</div>									
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<input id="photogalleryUp"  type="file" name="photogalleryUp" class="show-for-sr">
								<div id="mainGallery" class="gallery-pics">
									@foreach ($gallery as $key => $value)
										<div class="divPhotoGallery" data-pic="{{$value->id}}">
											<div class="afterGallery">
												<span class"fontRemove">
													<i class="fa fa-times-circle remove-image"></i>
												</span>													
											</div>						
											<img src="api/assets/img/api/commerce/photos/{{$value->image}}"/>
										</div>
									@endforeach
									<div id="gallerytoShow" class="drop-zone-photogallery">
										<div id="addnewPhoto" style="width: 30px; height: 30px; text-align: center;" class="divCircle-add">
											<span style="color:black;" ><i class="fa fa-upload"></i></span>											
										</div>
										<label style="text-align: center; line-height: 1.2; font-size: 19px;">320X240</label>
									</div>
								</div>								
								<div class="success progress logo" hidden style="width: 50%">
									<div id="gallery-progress" class="progress-meter" style="width: 0%"></div>
								</div>	
							</div>
							<!-- Manage Branchs -->
							<div class="small-12 medium-6 large-6 columns">
								<div class="small-12 medium-8 large-8 columns">
									<div class="row">
										<h4 class="myfont">Administra tus sucursales</h4>
									</div>
								</div>
								<div class="small-12 medium-4 large-4 columns">
									<div class="row">
										<input id="addNewBranch" style="float: right;" class="button myfontadd small-12 medium-9 large-8 columns"  value="Nueva sucursal">
									</div>
								</div>							
								<div  class="branch-div">
									<table id="tblBranch" class="display branchstable" cellspacing="0" width="100%">
										<thead >
											<tr >
												<th>NOMBRE</th>
												<th>TELEFONO</th>
												<th>OPCIONES</th>
											</tr>
										</thead>
										<tbody>
											@foreach($branchs AS $branch)
												<tr>
													<td>{{$branch->name}}</td>
													<td>{{$branch->phone}}</td>
													<td>
														<span><a class='edtBranch font-color-black'><i class='fa fa-pencil-square-o'></i></a></span>
														<span><a class='delBranch font-color-black'><i class='fa fa-trash-o'></i></a></span>
														<div class='divdata' hidden='true'>
															<data class='dataBranchRow'>{{$branch->idBranch}}</data>
															<data class='dataBranchAddress'>{{$branch->address}}</data>
															<data class='dataBranchLat'>{{$branch->lat}}</data>
															<data class='dataBranchLong'>{{$branch->long}}</data>
														</div>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>							
						</div>
					</form>
					<div class="row">
						<div class="small-12 medium-12 large-12 columns">
							<input id="updateCommerce" style="float: right;" type="submit" class="formbutton button"  value="Almacenar">
							<input id="cancelCommerce" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
						</div>
					</div>				
				</div>
				<div class="reveal middle-middle" id="modalNewBranch" data-reveal> <!-- modal add new Branch -->
					<div class="reveal-title">
						<h3  id="headerNewBranch" class="centerHeader">Nueva sucursal</h3>
					</div>
					<div class="reveal-body">
						<form data-abide novalidate id="addNewBranchForm" data-row="" class="standard-form">
							<div class="row">	
								<div class="small-12 medium-5 large-5 columns">
									<div class="row">
										<div class="row">
											<div class="large-3 columns">
												<label for="middle-label" class="label-form-inline text-left middle">Nombre:</label>
											</div>
											<div class="large-9 columns">
												<input class="label-form" id="branchName" required type="text" placeholder="Nombre">
												<span class="form-error"> Campo requerido </span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="row">
											<div class="large-3 columns">
												<label for="middle-label" class="label-form-inline text-left middle">Teléfono:</label>
											</div>
											<div class="large-9 columns">
												<input class="label-form" id="branchPhone" required type="text" placeholder="Teléfono">
												<span class="form-error"> Campo requerido </span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="row">
											<div class="large-3 columns">
												<label for="middle-label" class="label-form-inline text-left middle">Dirección:</label>
											</div>
											<div class="large-9 columns">
												<textarea maxlength="100" id="branchAddress" class="label-form" data-validator="max500char" required type="text" cols="100" style="height: 115px" placeholder="Dirección"></textarea>
												<span class="form-error"> Campo requerido </span>
											</div>
										</div>
									</div>										
								</div>
								<div class="small-12 medium-7 large-7 columns">
								<input id="locationEditable" type="checkbox"><label  class="label-form" for="locationEditable">Edita tu ubicación</label>
								<span hidden id="span-coords" class="alert">Ubicación requerida</span>
									<fieldset  class="gllpLatlonPicker">
										<div id="gllpMap" class="gllpMap">Google Maps</div>									
										<input type="text" placeholder="Ingresa una ubicación" id="autocomplete-google"> 
										<label hidden class="label-form">Latitud:
											<input id="latBranch" required type="hidden" type="text" class="gllpLatitude"  >									
										</label>
										<label hidden class="label-form">Longitud:
											<input id="longBranch" required type="hidden" type="text" class="gllpLongitude" >									
										</label>
										<input class="gllpZoom" value="12" type="hidden">
										<input type="button" class="gllpUpdateButton" hidden>
									</fieldset>
									<span class="form-error"> Campo requerido </span>
									<span class="alert">Nota: doble clic para establecer tu comercio en el mapa</span>
								</div>
							</div>	
						</form>
					</div>
					<div class="reveal-footer">
						<div class="row">
							<div class="small-12 medium-12 large-12 columns">
								<input id="saveBranch" style="float: right;" type="submit" class="formbutton standard button"  value="Almacenar">
								<input id="updateBranch" style="float: right;" type="submit" class="formbutton standard button"  value="Actualizar">
								<input id="closeModalBranch" style="float: right; margin-right: 20px;" type="button" class="cancel standard button"  value="Cancelar">
							</div>
						</div>
					</div>		
					<button class="close-button" data-close aria-label="Close modal" type="button">
						<span aria-hidden="true">&times;</span>
					</button>	
				</div> <!-- End modal Add new Branch-->				
			</div>
		</div>
	</div>
</div> <!-- End main div -->
@stop
@section('addJs')
	{{HTML::script('js/cmrce.js')}}
	{{HTML::script('/vendor/plugins/colorpicker/jquery.simplecolorpicker.js')}}
	{{HTML::script('http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&amp;language=es-MX')}}
	{{HTML::script('/vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.js')}}
	{{HTML::script('vendor/plugins/canvasresize/canvasResize.js')}}
	{{HTML::script('vendor/plugins/canvasresize/canvas-to-blob.js')}}
	{{HTML::script('vendor/plugins/canvasresize/exif.js')}}
	{{HTML::script('vendor/plugins/canvasresize/binaryajax.js')}}
	{{HTML::script('vendor/plugins/imgareaselect/jquery.imgareaselect.min.js')}}
	{{HTML::script('/vendor/plugins/data-tables/datatables.min.js')}}
	{{HTML::script('/vendor/plugins/messagemodal/js/jquery.modal.min.js')}}	
@stop
@stop