<?php
/**
* 
*/

class Role extends Eloquent
{

	protected $table = "role";
	public $timestamps = false;
	protected $SoftDelete = false;
	
	public static function getAllRoles() {
		$roles = self::select('id as idRole','name')->get();
		return $roles;
	}

}