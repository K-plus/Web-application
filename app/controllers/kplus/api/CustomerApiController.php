<?php namespace Kplus\Api\Controllers;

use Auth, Input;

class CustomerApiController extends ApiController {

	public function login()
	{
        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            $user = Auth::user();

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ];

            return $this->respond([
                'data' => $userData
            ]);
        }
        else
        {
            return $this->respondNotFound('Login credentials are invalid.');
        }
	}

}