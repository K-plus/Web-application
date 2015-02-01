<?php namespace Kplus\Services\Validation;


class ProfileFormValidator extends Validator {

	public $rules = array(
		'voornaam' => array( 'sometimes', 'alpha', 'min:2', 'max:200'),
		'achternaam' => array( 'sometimes', 'min:2', 'max:200' ), 
		'e-mail' => array( 'sometimes', 'email', 'min:6', 'max:200'),
		'wachtwoord' => array( 'sometimes', 'min:3', 'max:200'),
	);
}