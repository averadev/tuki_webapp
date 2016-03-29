<?php
/**
* 
*/

class Commerce extends Eloquent
{

	protected $table = "commerce";
	protected $SoftDelete = false;

	public static function getCommerceID(){
		/*Retorna el id del comercio que esta logiado*/
		$id = Auth::id();
		return Commerce::find($id);
	}	

	
} // END MODEL