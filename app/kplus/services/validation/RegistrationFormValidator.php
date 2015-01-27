<?php namespace Kplus\Services\Validation;


class RegistrationFormValidator extends Validator {

	public $rules = array(
		'voornaam' => array( 'required', 'alpha', 'min:2', 'max:200' ),
		'achternaam' => array( 'required' , 'min:2', 'max:200'),
		'e-mail' => array( 'required', 'email', 'min:6', 'max:200'),
		'wachtwoord' => array( 'required', 'min:3', 'max:200' ),
		'wachtwoord-herhalen' => array( 'required', 'min:3', 'max:200', 'same:wachtwoord'),
	);
}