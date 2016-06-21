<?php

class Reward extends Eloquent{
	/*const UPDATED_AT = null;
	const CREATED_AT = null;*/
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	protected $table = "reward";
	public $timestamps = true;
	protected $SoftDelete = false;


	public function getRewardsWithRedemptions(){
		$data = self::select('reward.id as rewardlist','reward.description','reward.terms','reward.image','reward.name','reward.points','reward.vigency',DB::raw('(SELECT count(idReward) FROM redemption WHERE redemption.idReward = reward.id AND redemption.status != 3) redemptionstotal'))
				->leftJoin('redemption as rdemp','rdemp.idReward','=','reward.id')
				->where('reward.idCommerce','=',Commerce::getCommerceID()->id)
				->groupBy('reward.id')
				->orderBy('reward.name')
				->get();
				//->toArray();
		return $data;

	}

	public function addNewReward($data){
		$this->idCommerce	= Commerce::getCommerceID()->id;
		$this->name			= $data->name;
		$this->description	= $data->description;
		$this->terms		= $data->terms;
		$this->points		= $data->points;
		$this->image		= $data->image;
		$this->vigency		= $data->vigency;
		$this->important	= 1;
		$this->status 		= 1;
		if($this->save()){
			return $this->id;
		}
		return false;
	}

	public function updateReward($data){
		$response = $this->find($data->rewardList);
		$response->name			= $data->name;
		$response->description	= $data->description;
		$response->terms		= $data->terms;
		$response->points		= $data->points;
		if($data->image){
			$response->image	= $data->image;
		}
		$response->vigency		= $data->vigency;
		$response->important	= 1;
		$response->status 		= 1;
		if($response->save()){
			return true;
		}
		return false;
	}
	/* Obtener recompensas del comercio mediante su $id para la ficha y su status */
	public function getCommerceRewardsTest($id){


		$dataRewardTest =  Reward::where( 'idCommerce', $id )
		->where('status', 1)
		->get();

		return $dataRewardTest;
	}

	
}