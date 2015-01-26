<?php namespace Kplus\Api\Controllers;

use Auth;
use Input;
    
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
            return $this->respondValidationError('Login credentials are invalid.');
        }
	}

}