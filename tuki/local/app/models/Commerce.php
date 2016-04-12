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

	public function geyMyCommerce(){
		/*Retorna los datos del comercio*/
		$data = self::select('commerce.id','commerce.name as comeName','description','commerce.image','banner','address','phone','web','facebook','twitter','lat','long','pltte.name','pltte.colorA1 as colorR','pltte.colorA2 as colorG','pltte.colorA3 as colorB')
		->where('commerce.id','=',Commerce::getCommerceID()->id)
		->leftJoin('palette as pltte','pltte.id','=','idPalette')
		->get();
		if (!$data->isEmpty()){
    		$data = $data->first();
		}
		return $data;
	}
	
} // END MODEL