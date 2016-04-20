@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/colorpicker/jquery.simplecolorpicker.css') }}
	{{ HTML::style('vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.css') }}
	{{ HTML::style('vendor/plugins/resizecropcanvas/component.css') }}
	{{ HTML::style('vendor/plugins/resizecropcanvas/demo.css') }}

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
						<h2 class="header-text not-selectable" unselectable="on">MI COMERCIO</h2>
					</div>
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
					<form data-abide id="addCommerce" class="standard-form">
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">													
								<label class="label-form">Nombre de tu comercio:
									<input maxlength="100" data-validator="max100char" id="commerceName" required type="text" value="{{$commerce->comeName}}" placeholder="Nombre"  >
									<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>
								<label class="label-form">Describe tu comercio en 50 palabras o menos:
									<textarea id="descriptionCom" maxlength="500" data-validator="max500char" required type="text" cols="50" style="height: 160px" placeholder="Descripcion">{{$commerce->description}}</textarea>
									<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>
							</div>
							<div class="small-12  medium-6  large-6  columns">
							<div class="row">
								<div class="reveal" id="modal-logo" data-reveal>
									<h4 class="centerHeader">Edita tu logotipo</h4>
									<div class="component">
										<div class="overlay">
											<div class="overlay-inner">
											</div>
										</div>
										<img id="imglogo" src=""/>
									</div>
									<div class="custom-panel-footer small-12 medium-12 large-12 columns">
										<input id="saveLogo" style="float: right; margin-right: 18px;" type="submit" class="formbutton button"  value="Aceptar">
										<input id="dismissModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="reveal" id="modal-portada" data-reveal>
									<h4 class="centerHeader">Edita tu Portada</h4>
									<div class="component portada">
										<div class="overlay portada">
											<div class="overlay-inner">
											</div>
										</div>						
										<img id="imgportada" style="max-width:200px; max-height:200px;" src=""/>
									</div>
									<div class="custom-panel-footer small-12 medium-12 large-12 columns">
										<input id="savePortada" style="float: right;" type="submit" class="formbutton button"  value="Aceptar">
										<input id="closeModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>								
								<div class="small-12 medium-6 large-6 columns">
									<label class="label-form">Tu imagen de logotipo:</label>
										<div class="logo-zone drop-zone-logotipo">
											<img id="imglogotoshow" src="{{$commerce->image }}"/>
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
											<img id="imgportadatoshow" src="{{$commerce->banner}}"/>
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
						<div class="small-12  medium-12  large-12  columns">
							<div class="row">
								<label class="label-form">Dirección:
									<input id="addressCom" maxlength="100" data-validator="max100char" required type="text" value="{{$commerce->address}}" placeholder="Dirección">
									<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>								
							</div>
						</div>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Teléfono:
									<input id="phoneCom" maxlength="30" data-validator="max30char" type="text" value="{{$commerce->phone}}" placeholder="Teléfono">
									<span class="form-error"></span>
								</label>
							</div>
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Página web:
									<input id="webCom" maxlength="100" data-validator="max100char" type="text" value="{{$commerce->web}}" placeholder="Página web">
									<span class="form-error"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Facebook:
									<input id="facebook" maxlength="150" data-validator="max150char" value="{{$commerce->facebook}}" type="text" placeholder="Facebook">
									<span class="form-error"></span>
								</label>
							</div>
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Twitter:
									<input id="twitter" maxlength="150" data-validator="max150char" type="text" value="{{$commerce->twitter}}" placeholder="Twitter">
									<span class="form-error"></span>
								</label>
							</div>
						</div>
						<h4 style="float: left;  margin-right: 20px;" class="myfont small-12  medium-12  large-12 ">Permitenos identificarte en el mapa</h4>
						<div class="row">
							<fieldset class="gllpLatlonPicker">
								<div class="small-12 medium-6 large-6 columns">
									<div class="gllpMap">Google Maps</div>
								</div>								
								<div class="small-12 medium-6 large-6 columns">
									<input type="button" id="locatemeID" class="formbutton button "  value="Localizame!">
									<input type="text" placeholder="Ingresa una ubicación" id="autocomplete-google"> 
									<label hidden class="label-form">Latitud:
										<input id="latCom" type="hidden" required type="text" class="gllpLatitude"  value="{{$commerce->lat}}">									
									</label>
									<label hidden class="label-form">Longitud:
										<input id="longCom" type="hidden" required type="text" class="gllpLongitude" value="{{$commerce->long}}">									
									</label>
									<input class="gllpZoom" value="12" type="hidden">
									<input type="button" class="gllpUpdateButton" hidden>
								</div>									
							</fieldset>							
						</div>
					</form>
					<div class="custom-panel-footer small-12 medium-12 large-12 columns">
						<input id="updateCommerce" style="float: right;" type="submit" class="formbutton button"  value="Almacenar">
						<input id="cancelCommerce" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
					</div>					
				</div>
			</div>
		</div>
	</div>
</div> <!-- End main div -->
@stop
@section('addJs')
	{{HTML::script('js/cmrce.js')}}
	{{HTML::script('/vendor/plugins/colorpicker/jquery.simplecolorpicker.js')}}
	{{HTML::script('http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false')}}
	{{HTML::script('/vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.js')}}
	{{HTML::script('vendor/plugins/resizecropcanvas/component.js')}}
	{{HTML::script('vendor/plugins/canvasresize/canvasResize.js')}}
	{{HTML::script('vendor/plugins/canvasresize/exif.js')}}
	{{HTML::script('vendor/plugins/canvasresize/binaryajax.js')}}	

@stop
@stop