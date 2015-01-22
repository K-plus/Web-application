<?php

class CustomerApiController extends ApiController {

	public function login()
	{
        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::validate(array('email' => $email, 'password' => $password)))
        {
            return $this->respondOk('Login ok.');
        }
        else
        {
            return $this->respondNotFound('Login credentials are invalid.');
        }
	}

}