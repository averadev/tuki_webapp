<?php

class LoginController extends BaseController {
	//public function __construct(){
	//	$this->beforeFilter('csrf',array('on' => 'post'));
	//}
	/*
	|--------------------------------------------------------------------------
	| Controlador para el login
	|--------------------------------------------------------------------------
	|
	*/

	public function getIndex(){
		if(Auth::check()){
			return View::make('welcome.home');
		}
		return View::make('login.login');
	}

	public function postLogIn(){
		$data = [
			'nombre'  =>trim(Input::get('user')),
			'password'=>trim(Input::get('pass'))
		];
		$rules = [
			'nombre'   => 'required',
			'password' =>'required'
		];
		$validator = Validator::make($data,$rules);
		if( $validator->passes() ){
			if (Auth::attempt($data)){
				return Redirect::to('/');
			}
		}
		return Redirect::back()->with('errorLogin',true);
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('/');
	}


}
