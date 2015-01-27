<?php namespace Kplus\Front\Controllers;

use Kplus\Services\Validation\RegistrationFormValidator;
use Kplus\Exceptions\ValidationException;
use Kplus\Models\User;

use Input, View, Redirect, Hash, Auth, Session, Crypt;

class CustomerController extends \BaseController 
{
	protected $_validator; 

	public function __construct( RegistrationFormValidator $validator ) {
        
        $this->_validator = $validator;

		$this->beforeFilter('csrf', array(
            'on' => array(
                'post',
                'put'
            )
        ));
	}

	// registratie pagina 
	public function getRegistrationIndex()
	{
		$view = View::make('kplus.registration.IndexView');

		$view->title 		= 'Registratie';
		$view->pageTitle 	= 'Registreren';
		$view->subTitle 	= 'Account aanmaken';

		return $view;
	}

	// profiel pagina 
	public function getProfile()
	{

	}

	// Registratie post
	public function postRegistration()
	{
		$input = Input::only('voornaam', 'achternaam', 'e-mail', 'wachtwoord', 'wachtwoord-herhalen');

		try {
            $validate_data = $this->_validator->validate( $input );

            $user = new User();
            $user->name = $input['voornaam'].' '.$input['achternaam'];
            $user->email = $input['e-mail'];
            $user->password = Hash::make($input['wachtwoord']);
            $user->save();

            Auth::attempt( array('email' => $user->email, 'password' => $input['wachtwoord']) );
            Session::put('username', Crypt::encrypt($user->email));

            return Redirect::route('home');
        } catch  ( ValidationException $e ) {
            return Redirect::route('registration')->withInput( $input )->withErrors( $e->get_errors() );
        }
	}

	// wijzigingen aan je profiel
	public function update()
	{

	}
}