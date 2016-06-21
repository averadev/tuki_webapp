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
		$id = Auth::user()->idCommerce;
		$data = self::select('id','name','image')
		->where('id','=',$id)
		->get();
		if (!$data->isEmpty()){
			$data = $data->first();
		}
		return $data;
	}

	public static function getBranchLoggedIn(){
		/*Retorna el id de la sucursal que esta logiado*/
		//$id = Auth::user()->idBranch;
		$id = Auth::user()->select('idBranch')->first()->toArray();
		if($id['idBranch']){
			return $id;
		}else{
			return  Branch::where('idCommerce','=',Commerce::getCommerceID()->id)->lists('id');
		}
		//$data = self::select('idCommerce','name','image')
		//->where('id','=',$id)
		//		->get();
		//if (!$data->isEmpty()){
		//	$data = $data->first();
		//}
			
	}


	public function geyMyCommerce(){
		/*Retorna los datos del comercio*/
		$data = self::select('commerce.id','detail','commerce.name as comeName','description','commerce.image','banner','web','facebook','twitter','pltte.name','pltte.bg1 as colorR','pltte.bg2 as colorG','pltte.bg3 as colorB')
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
		$response->name 		= $data->name;
		$response->detail		= $data->description;
		$response->description 	= $data->slogan;
		if($data->logoPath){
			$response->image		= $data->logoPath;
		}
		if($data->portadaPath){
			$response->banner		= $data->portadaPath;			
		}
		$response->web			= $data->website;
		$response->facebook		= $data->facebook;
		$response->twitter		= $data->twitter;
		$response->idPalette	= $data->color;
		if($response->save()){
			return true;
		}
		return false;
	}
	/* Obtener información del comercio mediante su $id para la ficha */
	public function getCommerceInformation($id){

		$data = self::select('commerce.name','commerce.image','pltte.bg1 as colorR','pltte.bg2 as colorG','pltte.bg3 as colorB')
		->where('commerce.id','=', $id)
		->leftJoin('palette as pltte','pltte.id','=','idPalette')
		->get();
		if (!$data->isEmpty()){
    		$data = $data->first();
		}
		return $data;

	}


	
} // END MODEL