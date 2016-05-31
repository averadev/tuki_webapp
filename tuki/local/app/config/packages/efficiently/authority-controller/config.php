<?php

return [

	'initialize' => function ($authority) {
		$user = Auth::guest() ? new User : $authority->getCurrentUser();
		/*Action aliases. For example:*/
		$authority->addAlias('adminUsers', ['postNewUser', 'putUpdateUser','deleteDropUser']);
		$authority->addAlias('adminRecompensas', ['postNewReward', 'putUpdateReward']);
		$authority->addAlias('adminComercio', ['putUpdateCommerce', 'postImageGallery','deleteDropPhotos']);
		$authority->addAlias('adminSucursales', ['postStoreBranch', 'putUpdateBranch','deleteDropBranch']);

		$authority->addAlias('show', ['getIndex']);
		if ($user->hasRole('gralAdmin')) {
			$authority->allow('show', 'all');
			$authority->allow('adminUsers', 'all');
			$authority->allow('adminSucursales', 'all');
			$authority->allow('adminComercio', 'all');
			$authority->allow('adminSucursales', 'all');
		}
		if ($user->hasRole('branchAdmin')) {
			$authority->allow('adminSucursales', 'all');
		}
		if ($user->hasRole('cashier')) {
			$authority->allow('show', 'all');
		}
		foreach($user->permissions as $perm) {
			if ($perm->type == 'allow') {
				$authority->allow($perm->action, $perm->resource);
			} else {
				$authority->deny($perm->action, $perm->resource);
			}
		}
		

	}

];
