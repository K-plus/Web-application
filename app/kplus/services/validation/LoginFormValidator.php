<?php namespace Kplus\Services\Validation;


class LoginFormValidator extends Validator {

	public $rules = array(
		'e-mail' => array( 'required', 'email', 'min:6', 'max:200'),
		'wachtwoord' => array( 'required', 'min:3', 'max:200'),
	);
}