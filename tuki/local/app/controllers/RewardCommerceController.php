<?php
	
	class RewardCommerceController extends BaseController{

		public function showRewardCommerce($idCommerce, $idReward){

			$commerce = new Commerce;
			$reward = new Reward;
			$branch = new Branch;

			$commerceInfo = $commerce->getCommerceInformation($idCommerce);
			$rewardInfo = $reward->getRewardCommerce($idCommerce, $idReward);
			$branchInfo = $branch->getBranchInformation($idCommerce);

			return View::make('rewards.rewardCommerce')
			->with('commerce',$commerceInfo)
			->with('reward',$rewardInfo)
			->with('branch',$branchInfo);

		}
	}