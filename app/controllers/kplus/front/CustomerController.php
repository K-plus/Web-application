<?php namespace Kplus\Front\Controllers;

use Kplus\Services\Validation\RegistrationFormValidator;
use Kplus\Services\Validation\ProfileFormValidator;
use Kplus\Exceptions\ValidationException;
use Kplus\Models\User;

use Input, View, Redirect, Hash, Auth, Session, Crypt;

class CustomerController extends \BaseController 
{
	protected $_validator; 
	protected $_profileFormValidator; 

	/**
	 * __construct.
	 * @param RegistrationFormValidator $validator [description]
	 */
	public function __construct( RegistrationFormValidator $validator, ProfileFormValidator $profileFormValidator ) {
        
        $this->_validator = $validator;
        $this->_profileFormValidator = $profileFormValidator;

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
		$view = View::make('kplus.profile.IndexView');
		$view->title = 'Profiel';
		$view->pageTitle = 'Profiel';
		$view->subTitle = 'Wijzig uw profiel';

		$user = Auth::user();
		$view->name = explode(' ',$user->name); 
		$view->user = $user;

		return $view;
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
		$input = Input::only('voornaam', 'achternaam', 'e-mail', 'wachtwoord', 'wachtwoord-herhalen');

		try{
			$validate_data = $this->_profileFormValidator->validate( $input );

			$user = Auth::user();
			$email = $input['e-mail'];
			$name = $input['voornaam'].' '.$input['achternaam']; 
			$password = $input['wachtwoord'];

			$user->update(array('email' => $email, 'name' => $name, 'password' => $password));
			
			// Put the sesison varialbes for us to use 
            Session::put('username', Crypt::encrypt($user->email));
			return Redirect::route('home');

		} catch ( ValidationException $e ) {
			return Redirect::route('profile')->withInput( $input )->withErrors( $e->get_errors() );
		}
	}
}