<?php

class CommerceController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para el login
	|--------------------------------------------------------------------------
	|
	*/
	public function getIndex(){
		if(Auth::check()){
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
		return View::make('login.login');
	}

	public function getStoredPics(){
		return View::make('commerce.trama');
	}

	public function postStoredPics(){
		return View::make('commerce.trama');
	}

	public function postStoreCommerce(){
		//$assetPath = '/files';
		//$uploadPath = public_path($assetPath);
		//$file = Request::file('fileupload');
		$file = $_FILES['fileupload'];

		//$file = Input::file('fileupload');
		//$destinationPath = public_path('/vendor/comer_logs');
		//$filename = $file->getClientOriginalName();
		//Input::file('fileupload')->move($destinationPath, $filename);
		return $file;
		//return 0;
	}

	public function postTempImage(){
		
		$file = $_FILES['fileupload'];

	}



	public function getLogout(){
		Auth::logout();
		return Redirect::to('/');
	}


}
