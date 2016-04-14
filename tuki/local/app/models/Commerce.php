<?php
/**
* 
*/

class Commerce extends Eloquent
{

	protected $table = "commerce";
	public $timestamps = false;
	protected $SoftDelete = false;


	/* G E T T E R S */

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

	public function checkLogo(){
		$data = self::select('image')
		->where('commerce.id','=',Commerce::getCommerceID()->id)
		->get();
		if (!$data->isEmpty()){
			$data = $data->first();
		}
		if($data->image){
			return true;
		}
		return false;	
	}

	public function checkPortada(){
		$data = self::select('banner')
		->where('commerce.id','=',Commerce::getCommerceID()->id)
		->get();
		if (!$data->isEmpty()){
			$data = $data->first();
		}
		if($data->banner){
			return true;
		}
		return false;		
	}

	/* S E T T E R S */

	public function updateCommerce($data){
		$response = $this->find(Commerce::getCommerceID()->id);
		$response->name 		= $data->name ;
		$response->description 	= $data->description;
		if($data->logoPath){
			$response->image		= $data->logoPath;
		}
		if($data->portadaPath){
			$response->banner		= $data->portadaPath;			
		}
		$response->address		= $data->address;
		$response->phone		= $data->phone;
		$response->web			= $data->website;
		$response->facebook		= $data->facebook;
		$response->twitter		= $data->twitter;
		$response->lat			= $data->lat;
		$response->long			= $data->long;
		$response->idPalette	= $data->color;
		if($response->save()){
			return true;
		}
		return false;
	}


	
} // END MODEL