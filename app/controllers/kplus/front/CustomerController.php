<?php namespace Kplus\Front\Controllers;

use Kplus\Services\Validation\RegistrationFormValidator;
use Kplus\Exceptions\ValidationException;
use Kplus\Models\User;

use Input, View, Redirect, Hash, Auth, Session, Crypt;

class CustomerController extends \BaseController 
{
	protected $_validator; 

	/**
	 * __construct.
	 * @param RegistrationFormValidator $validator [description]
	 */
	public function __construct( RegistrationFormValidator $validator ) {
        
        $this->_validator = $validator;

		$this->beforeFilter('csrf', array(
            'on' => array(
                'post',
                'put'
            )
        ));
	}

	/**
	 * getRegistrationIndex, gets the registration form
	 * for the users to register on . 
	 * @return View 	The registeration view
	 */
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

	/**
	 * postRegistration, gets the post request from the front-end.
	 * This registers the users and checks for validation.
	 * @return Redirect 	mixed 
	 */
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

            // log the user in 
            Auth::attempt( array('email' => $user->email, 'password' => $input['wachtwoord']) );
          
           	// Put the sesison varialbes for us to use 
            Session::put('username', Crypt::encrypt($user->email));
            
            Session::put('is_admin', Crypt::encrypt($user->is_admin));

            return Redirect::route('home');
        
        } catch  ( ValidationException $e ) {
        
            return Redirect::route('registration')->withInput( $input )->withErrors( $e->get_errors() );
        
        }
	}

	/**
	 * update, updates the credentials which are submitted. 
	 * @return .. 
	 */
	public function update()
	{

	}
}