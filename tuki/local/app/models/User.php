<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'commerce_user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/*FOR AUTHORITY CONFIGURATION*/
	public function roles()
	{
		return $this->belongsToMany('Role');
	}

	public function permissions()
	{
		return $this->hasMany('Permission');
	}

	public function hasRole($key)
	{
		$hasRole = false;
		foreach ($this->roles as $role) {
			if ($role->name === $key) {
				$hasRole = true;
				break;
			}
		}

		return $hasRole;
	}	

	/* ==== G E T T E R S =====*/
	public function getAllMyUsers(){
		$data = self::select('commerce_user.id as userRow','email', 'idBranch as branchID','roleuser.name as roleName','commerce_user.idCommerce','nombre','commbranch.name as branchName')
				->leftJoin('branch as commbranch','commbranch.id','=','commerce_user.idBranch')
				->leftJoin('role as roleuser','roleuser.id','=','commerce_user.idRole')
				->where('commerce_user.idCommerce','=',Commerce::getCommerceID()->id)
				->get();
		return $data;
	}

	/* ==== S E T T E R S =====*/
	public function addNewUser($data){
		$this->idBranch 	= $data->branch;
		if($data->pass_gen){ /*Si el usuario escogio autogenerar contraseña*/
			$password = Helper::randomPassword(10);
			$this->password = Hash::make($password);
		}else{
			$this->password = Hash::make($data->password);
		}
		if($data->admin_user){ /* Si el usuario a crear es de rol administrador */
			$this->idBranch = null;
			$this->idRole = null;
		}else{
			$this->idBranch = $data->branch;
			$this->idRole = $data->user_role;
		}
		$this->idCommerce 	= Commerce::getCommerceID()->id;
		$this->email 		= $data->email;
		$this->nombre		= $data->nombre;
		if($this->save()){
			/*Se manda el email con el user y password, si el usuario escogio autogenerar contraseña*/
			if($data->pass_gen){
				Mail::send('emails.password_gen', array('user'=>$this->nombre,'password'=>$password), function($message){
					$message->to($this->email,'credenciales')->subject('Su credenciales generadas');
				});
			}
			return $this->id;
		}
		return false;
	}

	/* ==== U P D A T E S =====*/
	
	public function upUser($data){
		$response = $this->find($data->dataRow);
		$response->nombre 	= $data->nombre;
		$response->email 	= $data->email;
		if($data->admin_user){ /* Si el usuario a crear es de rol administrador */
			$this->idBranch = null;
			$this->idRole = null;
		}else{
			$this->idBranch = $data->branch;
			$this->idRole = $data->user_role;
		}		
		if($response->save()){
			return true;
		}
		return false;
	}

	public function upPassword($data){
		$response = $this->find($data->dataRow);
		$response->password = Hash::make($data->password);
		if($response->save()){
			return true;
		}
		return false;
	}

	/* ==== D E L E T E====*/

	public function dropUser($row){
		$response = $this->find($row->dataRow);
		if($response->delete()){
			return true;
		}
		return false;
	}

}
