<?php

class CommerceController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	|	Controlador para el modulo de Comercio
 	|	Code By CarlosKF - GeekBucket -
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
		$gallery = new Xref_commerce_photos;
		$branch = new Branch;
		$listBranch = $branch->getAllActiveBranchs();
		//$branchs = $commerce->getBranchLoggedIn();
		//return var_dump($branchs);
		$galleryPhotos = $gallery->getAllGalleryPhotos();
		$paletteColors = $palette->getMyPaletteColors();
		$dataCommerce  = $commerce->geyMyCommerce();
		$colorCommerce = array($dataCommerce->colorR,$dataCommerce->colorG,$dataCommerce->colorB);
		$hexcodeColor =  Helper::rgb2hex($colorCommerce);
		return View::make('commerce.commerce')
		->with('commerce',$dataCommerce)
		->with('colorCommerce',$hexcodeColor)
		->with('paletteColors',$paletteColors)
		->with('gallery',$galleryPhotos)
		->with('branchs',$listBranch);
	}

	public function putUpdateCommerce(){
		if(Request::ajax()){
			$data = [
				'name' 			=> strip_tags(trim(Input::get('name'))),
				'slogan' 		=> strip_tags(trim(Input::get('slogan'))),
				'description' 	=> strip_tags(trim(Input::get('description'))),
				'color' 		=> strip_tags(trim(Input::get('color'))),
				'logo' 			=> strip_tags(trim(Input::get('logo'))),
				'portada' 		=> strip_tags(trim(Input::get('portada'))),
				'website' 		=> strip_tags(trim(Input::get('website'))),
				'facebook' 		=> strip_tags(trim(Input::get('facebook'))),
				'twitter' 		=> strip_tags(trim(Input::get('twitter')))
			];
			$rules = [
				'name' 			=> 'required|max:50',
				'slogan' 		=> 'required|max:50',
				'description' 	=> 'required|max:500',
				'color' 		=> 'required'
			];
			$commerce = new Commerce;
			$logoExist = $commerce->checkLogo();
			if(!$logoExist || $data['logo']){
				$rules['logo'] = 'required|valid_imagebase64';
			}
			$portadaExist = $commerce->checkPortada();
			if(!$portadaExist || $data['portada'] ){
				$rules['portada'] = 'required|valid_imagebase64';
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
				else if($validator->messages()->has('slogan'))
					$errorField = 'Slogan: '.$validator->messages()->first('slogan');
				return Response::json(array('error' => 1,'msg' => $errorField ));
			}

		}//end ajax request
	}
	
	/*Añade fotos al comercio*/
	public function postImageGallery(){
		if(Request::ajax()){
			//var_dump(Input::all());
			//Input::file('1galleryimage')->move('api/assets/img/api/commerce/photos/', 'prueba.jpg');
			try {
				$files = Input::file();
				//return var_dump($files);
				foreach ($files as $key => $file) {
				$extension = $file->getMimeType();
				$extensionName = Helper::getExtensionMime($extension);
				$completeName = Helper::nameMicroTime().'.'.$extensionName;
				$commerce_photos = new Xref_commerce_photos;
				$response = $commerce_photos->addNewGalleryPhotos($completeName);
					$file->move('api/assets/img/api/commerce/photos/', $completeName);
				}
				$gallery = new Xref_commerce_photos;
				$galleryPhotos = $gallery->getAllGalleryPhotos();
				return Response::json(array('photos'=>$galleryPhotos,'error'=>0));
			}catch (Exception $e) {
				return Response::json(array('error' => 1,'msg' =>  $e->getMessage()));
			}
		}
	}
	/*Elimina fotos del comercio*/
	public function deleteDropPhotos(){
		if(Request::ajax()){
			$row = Input::get('row');
			$row = json_decode($row);
			foreach ($row as $value) {
				$deletephoto = new Xref_commerce_photos;
				$deletephoto = $deletephoto->dropGalleryPhotos($value);
			}
		}
	}

	public function postStoreBranch(){
		if(Request::ajax()){
			$data = [
				'name'		=> strip_tags(trim(Input::get('name'))),		
				'address'	=> strip_tags(trim(Input::get('address'))),	
				'phone'		=> strip_tags(trim(Input::get('phone'))),		
				'lat'		=> strip_tags(trim(Input::get('latbranch'))),	
				'long'		=> strip_tags(trim(Input::get('longbranch')))
			];
			$rules = [
				'name'		=> 'required|unique:branch|max:30',
				'address'	=> 'required|max:100',
				'phone'		=> 'required|max:30',
				'lat' 		=> 'required|longitud_latitud',
				'long' 		=> 'required|longitud_latitud'
			];
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){
				$data = (object)$data;
				$branch = new Branch;
				$add_branch = $branch->addBranch($data);
				if($add_branch){
					return Response::json(array('dataRow'=>$add_branch,'error' => 0,'msg' => 'Sucursal registrada'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('name'))
					$errorField = 'Nombre: '.$validator->messages()->first('name');
				else if($validator->messages()->has('address'))
					$errorField = 'Dirección: '.$validator->messages()->first('address');
				else if($validator->messages()->has('phone'))
					$errorField = 'Teléfono: '.$validator->messages()->first('phone');
				else if($validator->messages()->has('lat'))
					$errorField = 'Latitud: '.$validator->messages()->first('lat');
				else if($validator->messages()->has('long'))
					$errorField = 'Longitud: '.$validator->messages()->first('long');
					return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	public function putUpdateBranch(){
		if(Request::ajax()){
			$data = [
				'branchRow'	=> strip_tags(trim(Input::get('branchRow'))),
				'name'		=> strip_tags(trim(Input::get('name'))),		
				'address'	=> strip_tags(trim(Input::get('address'))),	
				'phone'		=> strip_tags(trim(Input::get('phone'))),		
				'lat'		=> strip_tags(trim(Input::get('latbranch'))),	
				'long'		=> strip_tags(trim(Input::get('longbranch')))
			];
			$rules = [
				'branchRow' => 'required|integer',
				'name'		=> 'sometimes|required|unique:branch,name,'.$data['branchRow'].'|max:30',
				'address'	=> 'required|max:100',
				'phone'		=> 'required|max:30',
				'lat' 		=> 'required|longitud_latitud',
				'long' 		=> 'required|longitud_latitud'
			];
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){
				$data = (object)$data;
				$branch = new Branch;
				$up_branch = $branch->updateBranch($data);
				if($up_branch){
					return Response::json(array('error' => 0,'msg' => 'Sucursal actualizada'));					
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('name'))
					$errorField = 'Nombre: '.$validator->messages()->first('name');
				else if($validator->messages()->has('address'))
					$errorField = 'Dirección: '.$validator->messages()->first('address');
				else if($validator->messages()->has('phone'))
					$errorField = 'Teléfono: '.$validator->messages()->first('phone');
				else if($validator->messages()->has('lat'))
					$errorField = 'Latitud: '.$validator->messages()->first('lat');
				else if($validator->messages()->has('long'))
					$errorField = 'Longitud: '.$validator->messages()->first('long');
					return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	public function deleteDropBranch(){
		if(Request::ajax()){
			$data = [
				'dataRow' => strip_tags(trim(Input::get('daraRow')))
			];
			$rules = [
				'dataRow' => 'required|integer'
			];
			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				$branch = new Branch;
				$branchdel = $branch->dropBranch($data);
				if($branchdel){
					return Response::json(array('error' => 0,'msg' => 'Sucursal eliminada'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('dataRow'))
					$errorField = 'Error identificador: '.$validator->messages()->first('dataRow');
					return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	private function savelogoAndBanner($data){
		if($data->logo){
			$pathLogo 			= 'api/assets/img/api/commerce/';
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
			$pathPortada 		= 'api/assets/img/api/commerce/';
			$dataPortada 		= Helper::saveImage($data->portada,'BANNER',$pathPortada,'.png');
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
