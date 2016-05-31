<?php

class RewardsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Controlador para el modulo de recompensas
	| Code By CarlosKF - GeekBucket -
	|--------------------------------------------------------------------------
	|
	*/

	public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter('csrf',array('except'=>array('getIndex')));
		//$this->loadAndAuthorizeResource();
	}

	public function getIndex(){
		$reward = new Reward;
		$rewards = $reward->getRewardsWithRedemptions();
		$data = Commerce::getCommerceID();
		return View::make('rewards.rewards')
		->with('commerce',$data)
		->with('rewards',$rewards);
	}

	public function postNewReward(){
		if(Request::ajax()){
			$data = [
				'name'		 	=> strip_tags(trim(Input::get('name'))),
				'description'	=> strip_tags(trim(Input::get('description'))),
				'terms'		 	=> strip_tags(trim(Input::get('terms'))),
				'points'	 	=> strip_tags(trim(Input::get('points'))),
				'image' 	 	=> strip_tags(trim(Input::get('image'))),
				'vigency'	 	=> strip_tags(trim(Input::get('vigency')))
			];
			$rules = [
				'name'		 	=> 'required|max:45',
				'description'	=> 'required|max:140',
				'terms'		 	=> 'required|max:500',
				'points'	 	=> 'required|integer',
				'image' 	 	=> 'required|valid_imagebase64',
				'vigency'	 	=> 'required|date_format:"d/m/Y"|date_greater_than_today'
			];

			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				$data = $this->saveRewardImage($data);				
				$reward = new Reward;
				$data->vigency = Helper::convertDateOne($data->vigency);
				$rewardSave = $reward->addNewReward($data);
				if($rewardSave){
					return Response::json(array('listReward'=>$rewardSave,'vigency'=>$data->vigency,'image'=>$data->image,'msg'=>'Recompensa registrada','error'=>0));
				}
			}else{
				$messages = $validator->messages();

				if($validator->messages()->has('name'))
					$errorField = 'Nombre: '.$validator->messages()->first('name');
				else if($validator->messages()->has('description'))
					$errorField = 'Descripción: '.$validator->messages()->first('description');
				else if($validator->messages()->has('terms'))
					$errorField = 'Terminos y condiciones: '.$validator->messages()->first('terms');
				else if($validator->messages()->has('points'))
					$errorField = 'Puntos: '.$validator->messages()->first('points');
				else if($validator->messages()->has('image'))
					$errorField = 'Imagen: '.$validator->messages()->first('image');
				else if($validator->messages()->has('vigency'))
					$errorField = 'Vigencia: '.$validator->messages()->first('vigency');

				return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	public function putUpdateReward(){
		if(Request::ajax()){
			$data = [
				'rewardList'	=> strip_tags(trim(Input::get('rewardList'))),
				'name'		 	=> strip_tags(trim(Input::get('name'))),
				'description'	=> strip_tags(trim(Input::get('description'))),
				'terms'		 	=> strip_tags(trim(Input::get('terms'))),
				'points'	 	=> strip_tags(trim(Input::get('points'))),
				'image' 	 	=> strip_tags(trim(Input::get('image'))),
				'vigency'	 	=> strip_tags(trim(Input::get('vigency')))
			];
			$rules = [
				'rewardList' 	=> 'required|integer',
				'name'		 	=> 'required|max:45',
				'description'	=> 'required|max:140',
				'terms'		 	=> 'required|max:500',
				'points'	 	=> 'required|integer',
				'vigency'	 	=> 'required|date_format:"d/m/Y"'
			];
			if($data['image']){
				$rules['image'] = 'valid_imagebase64';
			}

			$validator = Validator::make($data,$rules);
			if($validator->passes()){
				$data = (object)$data;
				if($data->image){ /*Si se agrego una nueva imagen*/
					$data = $this->saveRewardImage($data);
				}
				$data->vigency	= Helper::convertDateOne($data->vigency);
				$reward = new Reward;
				$rewardSave = $reward->updateReward($data);
				if($rewardSave){
					return Response::json(array('vigency'=>$data->vigency,'image'=>$data->image,'msg'=>'Recompensa actualizada','error'=>0));
				}				
			}else{
				$messages = $validator->messages();

				if($validator->messages()->has('name'))
					$errorField = 'Nombre: '.$validator->messages()->first('name');
				else if($validator->messages()->has('description'))
					$errorField = 'Descripción: '.$validator->messages()->first('description');
				else if($validator->messages()->has('terms'))
					$errorField = 'Terminos y condiciones: '.$validator->messages()->first('terms');
				else if($validator->messages()->has('points'))
					$errorField = 'Puntos: '.$validator->messages()->first('points');
				else if($validator->messages()->has('image'))
					$errorField = 'Imagen: '.$validator->messages()->first('image');
				else if($validator->messages()->has('vigency'))
					$errorField = 'Vigencia: '.$validator->messages()->first('vigency');

				return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	private function saveRewardImage($data){
		if($data->image){
			$pathImg 			= 'api/assets/img/api/rewards/';
			$dataImg 			= Helper::saveImage($data->image,'REWARD',$pathImg,'.png');
			if($dataImg){
				$data->image 	= $dataImg;
			}else{
				$data->image 	= false;
			}
		}else{
			$data->image 	= false;
		}
		return $data;
	}	
	

}