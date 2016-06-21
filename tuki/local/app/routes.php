<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
	Route::get('/comercios/{id}','RewardsCommerceController@showRewards');
	Route::controller('/perfiles', 'UsersController');
	Route::controller('/recompensas', 'RewardsController');
	Route::controller('/reportes', 'ReportController');
	Route::controller('/comercio', 'CommerceController');
	Route::controller('/home', 'HomeController');
	Route::controller('/passreset', 'RemindersController');	
	Route::controller('/', 'LoginController');

	


