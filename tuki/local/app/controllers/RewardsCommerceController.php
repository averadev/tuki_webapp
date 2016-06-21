<?php 

	class RewardsTestController extends BaseController{

		//models -> Branch, Commerce, Rewards

		public function showRewards($id){

			$rewardTest = new Reward;
			$commerceInfo = new Commerce;
			$branchInfo = new Branch;

			$commerceInformation = $commerceInfo->getCommerceInformation($id);
			$branchsInfo = $branchInfo->getBranchInformation($id);
			$rewardsTest = $rewardTest->getCommerceRewardsTest($id);

			return View::make('rewardsCommerce')

			->with('commerce',$commerceInformation)
			
			->with('rewards',$rewardsTest)

			->with('branchs',$branchsInfo);
		}
	}

 ?>