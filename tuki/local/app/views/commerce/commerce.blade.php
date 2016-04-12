@extends('template.main')
@section('addCss')
	{{ HTML::style('vendor/plugins/colorpicker/jquery.simplecolorpicker.css') }}
	{{ HTML::style('vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.css') }}
	{{ HTML::style('vendor/plugins/resizecropcanvas/component.css') }}
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
                <div class="custom-panel-details small-12 medium-12 large-12 columns">
                	<form data-abide novalidate id="addCommerce" class="standard-form">
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">													
								<label class="label-form">Nombre de tu comercio:
									<input maxlength="100" data-validator="max100char" id="commerceName" required type="text" value="{{$commerce->comeName}}" placeholder="Nombre"  >
								        <span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>
								<label class="label-form">Describe tu comercio en 50 palabras o menos:
									<textarea maxlength="500" data-validator="max500char" required type="text" cols="50" style="height: 160px" placeholder="Descripcion">{{$commerce->description}} </textarea>
								   	<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>
							</div>
							<div class="small-12  medium-6  large-6  columns">
							<div class="row">
								<div class="reveal" id="modal-logo" data-reveal>
									<h4>Editar logotipo</h4>
									<div class="component drop-zone-logotipo">									
										<img id="imglogo" src=""/>
									</div>
									<div class="custom-panel-footer small-12 medium-12 large-12 columns">
										<input id="updateCommerce" style="float: right;" type="submit" class="formbutton button"  value="Aceptar">
										<input id="dismissModal" style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="small-12 medium-6 large-6 columns">
									<label class="label-form">Tu imagen de logotipo: </label>
									<div class="logo-zone">
										<img src="{{$commerce->image }}"/>
									</div>	
									<label for="fileupload" class="formbutton button ">Examinar</label>
									<input id="fileupload" required type="file" name="fileupload" class="show-for-sr">
																				
								</div>
								<div class="small-12 medium-6 large-6 large columns">
									<label class="label-form">Tu imagen de portada: </label>	
									<div class="component drop-zone-portada">
										<img id="imgportada" src=""/>
									</div>	
									<label for="portada-upload" class="formbutton button ">Examinar</label>
									<input required id="portada-upload" type="file" name="portada-upload" class="show-for-sr">																			
								</div>  								
  								<div class="small-12 medium-6 large-6 columns">
  									<label class="label-form ">Color para identificar a tu comercio:</label>								
  								</div>
  								<div class="small-12 medium-6 large-6 columns" >									
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
									<input maxlength="100" data-validator="max100char" required type="text" value="{{$commerce->address}}" placeholder="Dirección">
									<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
								</label>								
							</div>
						</div>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Teléfono:
									<input maxlength="30" data-validator="max30char" type="text" value="{{$commerce->phone}}" placeholder="Teléfono">
									<span class="form-error"></span>
								</label>
							</div>
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Página web:
									<input maxlength="100" data-validator="max100char" type="text" value="{{$commerce->web}}" placeholder="Página web">
									<span class="form-error"></span>
								</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Facebook:
									<input maxlength="150" data-validator="max150char" value="{{$commerce->facebook}}" type="text" placeholder="Facebook">
									<span class="form-error"></span>
								</label>
							</div>
							<div class="small-12 medium-6 large-6 columns">
								<label class="label-form">Twitter:
									<input maxlength="150" data-validator="max150char" type="text" value="{{$commerce->twitter}}" placeholder="Twitter">
									<span class="form-error"></span>
								</label>
							</div>
						</div>
						<h4 style="float: left;  margin-right: 20px;" class="myfont small-12  medium-12  large-12 ">Permitenos identificarte en el mapa</h4>
						<div class="row">							
							<fieldset class="gllpLatlonPicker">
								<div class="mall-12 medium-6 large-6 columns">
									<div class="gllpMap">Google Maps</div>
								</div>								
								<div class="mall-12 medium-6 large-6 columns">
									<label class="label-form">Latitud:
										<input required type="text" class="gllpLatitude"  value="{{$commerce->lat}}">
										<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
									</label>
									<label class="label-form">Longitud:
										<input required type="text" class="gllpLongitude" value="{{$commerce->long}}">
										<span class="form-error" style="font-size: 20px;"> Campo requerido </span>
									</label>
									<input class="gllpZoom" value="11" type="hidden">
									<input type="button" class="gllpUpdateButton formbutton button "  value="Actualizar mapa">
								</div>									
							</fieldset>							
						</div>
						<div class="custom-panel-footer small-12 medium-12 large-12 columns">
							<input id="updateCommerce" style="float: right;" type="submit" class="formbutton button"  value="Almacenar">
							<input style="float: right; margin-right: 20px;" type="button" class="cancel button"  value="Cancelar">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> <!-- End main div -->
@stop
@section('addJs')
	{{HTML::script('js/cmrce.js')}}
	{{HTML::script('/vendor/plugins/colorpicker/jquery.simplecolorpicker.js')}}
	{{HTML::script('http://maps.googleapis.com/maps/api/js?sensor=false')}}
	{{HTML::script('/vendor/plugins/locationpickergmaps/jquery-gmaps-latlon-picker.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.ui.widget.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/load-image.all.min.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.iframe-transport.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.fileupload.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.fileupload-process.js')}}	
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.fileupload-image.js')}}
	{{HTML::script('/vendor/plugins/jqueryuploader/js/jquery.fileupload-validate.js')}}
	{{HTML::script('vendor/plugins/resizecropcanvas/component.js')}}
@stop
@stop