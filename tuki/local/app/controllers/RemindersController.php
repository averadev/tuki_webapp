<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		if(Request::ajax()){
			$data = [
				'email'  =>	strip_tags(trim(Input::get('email')))
			];

			$rules = [
				'email' => 'required|email'
			];
			$validator = Validator::make($data,$rules);
			if( $validator->passes() ){	

			$response = Password::remind(Input::only('email'), function($message)
			{
			    $message->subject('Restablecer contraseña');
			});
			switch ($response)
			{
				case Password::INVALID_USER:
					return Response::json(array('error' => 1,'msg' => Lang::get($response)));
				case Password::REMINDER_SENT:
					return Response::json(array('success' => 1,'msg' => Lang::get($response)));
			}
			}else{
				$messages = $validator->messages();
				if($validator->messages()->has('email')){
					$errorField = 'Correo: '.$validator->messages()->first('email');				
				}
				return Response::json(array('error' => 1,'msg' => $errorField ));
			}
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postResetPass()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
				return Response::json(array('error' => 1,'msg' => Lang::get($response)));
			case Password::INVALID_TOKEN:
				return Response::json(array('error' => 1,'msg' => Lang::get($response)));
			case Password::INVALID_USER:
				return Response::json(array('error' => 1,'msg' => Lang::get($response)));
			case Password::PASSWORD_RESET:
				return Response::json(array('error' => 1,'msg' => Lang::get($response)));
		}
	}

}