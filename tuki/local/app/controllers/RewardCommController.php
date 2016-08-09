<?php
	/*Controlador para mostrar recompensa elegida*/
	class RewardCommController extends BaseController{

		public function showRewardCommerce($idCommerce, $idReward){

			$commerce = new Commerce;
			$reward = new Reward;
			$branch = new Branch;

			$commerceInfo = $commerce->getCommerceInformation($idCommerce);
			$rewardInfo = $reward->getCommReward($idCommerce, $idReward);
			$branchInfo = $branch->getBranchInformation($idCommerce);

			return View::make('rewards.rewardCommerce')
						->with('commerce',$commerceInfo)
						->with('reward',$rewardInfo)
						->with('branch',$branchInfo);

		}
	}