<?php

class LoginController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para el login
	|--------------------------------------------------------------------------
	|
	*/

	public function getIndex(){
		if(Auth::check()){
			$id = Auth::id();
			$data = Commerce::find($id);
			$dataCommerce = new stdClass();
			$dataCommerce->id = $data->id;
			$dataCommerce->image = $data->image;
			$dataCommerce->name = $data->name;
			$now = new DateTime();
  			$month = $now->format('n');		
			$dataChart = json_encode(Log_new_user_commerce::getDataByMonth($data,'03'));					
			return View::make('welcome.home')
			->with('commerce',$dataCommerce)
			->with('chartcom',$dataChart)
			->with('month',$month);
		}
		return View::make('login.login');
	}

	public function postLogIn(){
		if(Request::ajax()){
			$data = [
				'nombre'   => trim(Input::get('user')),
				'password' => trim(Input::get('pass'))
			];
			$rules = [
				'nombre'   => 'required',
				'password' => 'required'
			];
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){
				if (Auth::attempt($data)){
					return Response::json(array('success'=>true),200);
				}else{
					return Response::json(array('success'=>false),200);
				}
			}
			return Redirect::back()->with('errorLogin',true);
		}
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::to('/');
	}


}
