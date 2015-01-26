<?php namespace Kplus\Services\Validation;

use Illuminate\Validation\Factory as IlluminateValidator;
use Kplus\Exceptions\ValidationException;

abstract class Validator {
	protected $_validator;

	public function __construct( IlluminateValidator $validator ) {
		$this->_validator = $validator;
	}

	public function validate( array $data, array $rules = array(), array $custom_errors = array() ) {
		if( empty ($rules) && ! empty( $this->rules ) && is_array( $this->rules ) ) {
			$rules = $this->rules;
		}

		$validation = $this->_validator->make( $data, $rules, $custom_errors );

		if( $validation->fails() ) {
			throw new ValidationException( $validation->messages() );
		}

		// validation passes 
		return true;
	}
}