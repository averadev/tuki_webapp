<?php 
	
	/*Controlador ficha comercio para recompensas disponibles */
	class RewardsCommerceController extends BaseController{

		//models : Branch, Commerce, Rewards

		public function showRewards($id){

			$reward = new Reward;
			$commerceInfo = new Commerce;
			$branchInfo = new Branch;

			$commerceInformation = $commerceInfo->getCommerceInformation($id);
			$branchsInfo = $branchInfo->getBranchInformation($id);
			$rewards = $reward->getCommerceRewards($id);

			return View::make('rewards.rewardtest')
						->with('commerce',$commerceInformation)
						->with('rewards',$rewards)
						->with('branchs',$branchsInfo);
		}

	}

 ?>