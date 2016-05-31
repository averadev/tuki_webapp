<?php

class UsersController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Controlador para el modulo de Usuarios y Permisos
	| Code By CarlosKF - GeekBucket -
	|--------------------------------------------------------------------------
	|
	*/

	function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf',array('except'=>array('getIndex')));
	}

	public function getIndex(){
		$users = new User;
		$users = $users->getAllMyUsers();
		$branch = new Branch();
		$branch = $branch->getAllActiveBranchs();
		$data = Commerce::getCommerceID();
		$roles = Role::getAllRoles();
		return View::make('users.users')
		->with('commerce',$data)
		->with('branchs',$branch)
		->with('users',$users)
		->with('roles',$roles);
	}

	public function postNewUser(){
		if(Request::ajax()){
			$data = [
				'nombre'				=> strip_tags(trim(Input::get('nombre'))),
				'branch'				=> strip_tags(trim(Input::get('branch'))),
				'email'					=> strip_tags(trim(Input::get('email'))),
				'password' 				=> strip_tags(trim(Input::get('password'))),
				'password_confirmation'	=> strip_tags(trim(Input::get('confirm'))),
				'user_role'				=> strip_tags(trim(Input::get('user_role'))),
				'admin_user'			=> strip_tags(trim(Input::get('admin_user'))) == 'true' ? TRUE:FALSE,
				'pass_gen'				=> strip_tags(trim(Input::get('pass_gen'))) == 'true' ? TRUE:FALSE
			];
			$rules = [
				'nombre'				=>	'required|max:100',
				'email'					=>	'required|email|max:60'
			];
			if(!($data['admin_user'])){/*Si el usario a crear NO es administrador*/
				$rules['user_role'] = 'required|integer';
				$rules['branch']	= 'required|integer';
			}
			if(!($data['pass_gen'])){ /*Si el password NO se autogenerara*/
				$rules['password'] = 'required|max:60|confirmed';
				$rules['password_confirmation'] = 'required';				
			}
			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				$user = new User;
				$user = $user->addNewUser($data);
				if($user){
					return Response::json(array('dataRow'=>$user,'error' => 0,'msg' => 'Usuario registrado'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('nombre'))
					$errorField = 'Nombre: '.$validator->messages()->first('nombre');
				else if($validator->messages()->has('branch'))
					$errorField = 'Sucursal: '.$validator->messages()->first('branch');
				else if($validator->messages()->has('user_role'))
					$errorField = 'Usuario: '.$validator->messages()->first('user_role');				
				else if($validator->messages()->has('email'))
					$errorField = 'Email: '.$validator->messages()->first('email');
				else if($validator->messages()->has('password'))
					$errorField = 'Password: '.$validator->messages()->first('password');
				else if($validator->messages()->has('password_confirmation'))
					$errorField = 'Confirmacion de password: '.$validator->messages()->first('password_confirmation');
				return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	public function putUpdateUser(){
		if(Request::ajax()){
			$data = [
				'dataRow'		=> strip_tags(trim(Input::get('dataRow'))),
				'nombre'		=> strip_tags(trim(Input::get('nombre'))),
				'branch'		=> strip_tags(trim(Input::get('branch'))),
				'email'			=> strip_tags(trim(Input::get('email'))),
				'user_role'		=> strip_tags(trim(Input::get('user_role'))),				
				'admin_user'	=> strip_tags(trim(Input::get('admin_user'))) == 'true' ? TRUE:FALSE,				
			];
			$rules = [
				'dataRow'	=>	'required|integer',
				'nombre'	=>	'required|max:100',
				'email'		=>	'required|email|max:60'
			];
			if(!($data['admin_user'])){/*Si el usario a crear NO es administrador*/
				$rules['user_role'] = 'required|integer';
				$rules['branch']	= 'required|integer';
			}			
			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				$user = new User;
				$user = $user->upUser($data);
				if($user){
					return Response::json(array('error' => 0,'msg' => 'Usuario Actualizado'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('dataRow'))
					$errorField = 'Error identificador: '.$validator->messages()->first('dataRow');				
				else if($validator->messages()->has('nombre'))
					$errorField = 'Nombre: '.$validator->messages()->first('nombre');
				else if($validator->messages()->has('user_role'))
					$errorField = 'Usuario: '.$validator->messages()->first('user_role');	
				else if($validator->messages()->has('branch'))
					$errorField = 'Sucursal: '.$validator->messages()->first('branch');
				else if($validator->messages()->has('email'))
					$errorField = 'Email: '.$validator->messages()->first('email');
				return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	public function putUpdatePass(){
		if(Request::ajax()){
			$data = [
				'dataRow'				=> strip_tags(trim(Input::get('dataRow'))),
				'password'				=> strip_tags(trim(Input::get('password'))),
				'password_confirmation'	=> strip_tags(trim(Input::get('confirm')))
			];
			$rules = [
				'dataRow'				=>	'required|integer',
				'password' 				=>	'required|max:60|confirmed',
				'password_confirmation'	=>	'required|'			
			];
			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				$user = new User();
				$user = $user->upPassword($data);
				if($user){
					return Response::json(array('error' => 0,'msg' => 'Contraseña actualizada'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('dataRow'))
					$errorField = 'Error identificador: '.$validator->messages()->first('dataRow');
				else if($validator->messages()->has('password'))
					$errorField = 'Password: '.$validator->messages()->first('password');			
				else if($validator->messages()->has('password_confirmation'))
					$errorField = 'Confirmacion de password: '.$validator->messages()->first('password_confirmation');				
				return Response::json(array('error' => 1,'msg' => $errorField ));				
			}
		}
	}

	public function deleteDropUser(){
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
				$user = new User;
				$user = $user->dropUser($data);
				if($user){
					return Response::json(array('error' => 0,'msg' => 'Usuario eliminado'));
				}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('dataRow'))
					$errorField = 'Error identificador: '.$validator->messages()->first('dataRow');
					return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}
}