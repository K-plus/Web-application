<?php namespace Kplus\Services\Validation;


class LoginFormValidator extends Validator {

	public $rules = array(
		'email' => array( 'required', 'email', 'min:6', 'max:200'),
		'password' => array( 'required', 'min:3', 'max:200'),
	);
}