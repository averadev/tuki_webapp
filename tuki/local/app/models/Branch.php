<?php
/**
* 
*/

class Branch extends Eloquent
{

	protected $table = "branch";
	public $timestamps = false;
	protected $SoftDelete = false;

	public function getAllActiveBranchs(){
		/*Retonar todas las sucursales de un comercio logiado*/
		$data = self::select('id AS idBranch','name','address','phone','lat','long')
				->where('branch.idCommerce','=',Commerce::getCommerceID()->id)
				->where('branch.status','=',1)
				->get();
		return $data;
	}

	public function getBranchUser(){
		
	}

	public function addBranch($data){
		$this->idCommerce 	= Commerce::getCommerceID()->id;
		$this->name 		= $data->name;
		$this->address 		= $data->address;
		$this->phone 		= $data->phone;
		$this->lat 			= $data->lat;
		$this->long 		= $data->long;
		$this->status 		= 1;
		if($this->save()){
			return $this->id;
		}
			return false;
	}

	public function updateBranch($data){
		$response = $this->find($data->branchRow);
		$response->name 	= $data->name;
		$response->address 	= $data->address;
		$response->phone 	= $data->phone;
		$response->lat 		= $data->lat;
		$response->long 	= $data->long;
		if($response->save()){
			return true;
		}
		return false;		
	}

	/* ==== D E L E T E====*/

	public function dropBranch($row){
		$response = $this->find($row->dataRow);
		$response->status = 0;
		if($response->save()){
			return true;
		}
		return false;
	}
	/* Información de los comercios para la ficha*/ 
	public function getBranchInformation($id){
		$dataBranchInformation = Branch::where( 'idCommerce', '=', $id )
								->get();
		return $dataBranchInformation;
	}

}