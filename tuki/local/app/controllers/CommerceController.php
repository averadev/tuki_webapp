<?php

class CommerceController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para el comercio
	|--------------------------------------------------------------------------
	|
	*/
	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf',array('except' => array('getIndex')));
	}	
	public function getIndex(){
		$commerce = new Commerce;
		$palette = new Palette;
		$paletteColors = $palette->getMyPaletteColors();
		$dataCommerce = $commerce->geyMyCommerce();
		$colorCommerce = array($dataCommerce->colorR,$dataCommerce->colorG,$dataCommerce->colorB);
		$hexcodeColor =  Helper::rgb2hex($colorCommerce);
		return View::make('commerce.commerce')
		->with('commerce',$dataCommerce)
		->with('colorCommerce',$hexcodeColor)
		->with('paletteColors',$paletteColors);
	}

	public function postStoreCommerce(){
		if(Request::ajax()){
			$data = [
				'name' 			=> strip_tags(trim(Input::get('name'))),
				'description' 	=> strip_tags(trim(Input::get('description'))),
				'color' 		=> strip_tags(trim(Input::get('color'))),
				'logo' 			=> strip_tags(trim(Input::get('logo'))),
				'portada' 		=> strip_tags(trim(Input::get('portada'))),
				'address' 		=> strip_tags(trim(Input::get('address'))),
				'phone' 		=> strip_tags(trim(Input::get('phone'))),
				'website' 		=> strip_tags(trim(Input::get('website'))),
				'facebook' 		=> strip_tags(trim(Input::get('facebook'))),
				'twitter' 		=> strip_tags(trim(Input::get('twitter'))),
				'lat' 			=> strip_tags(trim(Input::get('lat'))),
				'long' 			=> strip_tags(trim(Input::get('long')))
			];
			$rules = [
				'name' 			=> 'required',
				'description' 	=> 'required',
				'color' 		=> 'required',
				'address' 		=> 'required',
				'lat' 			=> 'required|longitud_latitud',
				'long' 			=> 'required|longitud_latitud'
			];
			$commerce = new Commerce;
			$logoExist = $commerce->checkLogo();
			if(!$logoExist){
				$rules['logo'] = 'required';
			}
			$portadaExist = $commerce->checkPortada();
			if(!$portadaExist){
				$rules['portada'] = 'required';
			}
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){
				$data = (object)$data;
				$data = $this->savelogoAndBanner($data);
				$commerce = new Commerce;
				$upCommerce = $commerce->updateCommerce($data);
				return Response::json(array('msg'=>'Comercio actualizado','error'=>0));
			}else{
				$messages = $validator->messages();

				if($validator->messages()->has('name'))
					$errorField = 'Nombre: '.$validator->messages()->first('name');
				else if($validator->messages()->has('description'))
					$errorField = 'Descripción: '.$validator->messages()->first('description');
				else if($validator->messages()->has('color'))
					$errorField = 'Color: '.$validator->messages()->first('color');
				else if($validator->messages()->has('logo'))
					$errorField = 'Logo: '.$validator->messages()->first('logo');
				else if($validator->messages()->has('portada'))
					$errorField = 'Portada: '.$validator->messages()->first('portada');
				else if($validator->messages()->has('address'))
					$errorField = 'Dirección: '.$validator->messages()->first('address');
				else if($validator->messages()->has('lat'))
					$errorField = 'Latitud: '.$validator->messages()->first('lat');
				else if($validator->messages()->has('long'))
					$errorField = 'Longitud: '.$validator->messages()->first('long');

				return Response::json(array('error' => 1,'msg' => $errorField ));
			}

		}//end ajax request
	}

	private function savelogoAndBanner($data){
		if($data->logo){
			$pathLogo 			= 'vendor/comer_logs/';
			$dataLogo 			= Helper::saveImage($data->logo,'LOGO',$pathLogo,'.png');
			if($dataLogo){
				$data->logoPath 	= $dataLogo;
			}else{
				$data->logoPath 	= false;
			}					
		}else{
			$data->logoPath 	= false;
		}

		if($data->portada){
			$pathPortada 		= 'vendor/comer_frontpics/';
			$dataPortada 		= Helper::saveImage($data->portada,'PORTADA',$pathPortada,'.png');
			if($dataPortada){
				$data->portadaPath 	= $dataPortada;
			}else{
				$data->portadaPath 	= false;
			}			
		}else{
			$data->portadaPath 	= false;
		}

		return $data;
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('/');
	}


}
