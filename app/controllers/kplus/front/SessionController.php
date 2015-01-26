<?php namespace Kplus\Front\Controllers;

use Kplus\Services\Validation\LoginFormValidator;
use Kplus\Exceptions\ValidationException;
use View;
use Input;
use Auth;
use Redirect; 
use Session;
use Crypt;

class SessionController extends \BaseController
{
	/**
	  * LoginFormValidator object that verifies the login form.
     */
    protected $_validator;
 
    public function __construct( LoginFormValidator $validator ) {
        
        $this->_validator = $validator;

		$this->beforeFilter('csrf', array(
            'on' => array(
                'post',
                'put'
            )
        ));
	}

	public function getIndex() 
	{
		$view = View::make('kplus.login.IndexView');
		
		$view->title = 'Login';
		
		$view->pageTitle = 'Login';
		$view->subTitle = 'Login om verder te gaan';

		return $view;		
	}

	public function postLogin()
	{
		$input = Input::only('email', 'password');

		try {
            
            $validate_data = $this->_validator->validate( $input );
            
            if( Auth::attempt(array('email' => $input['email'], 'password' => $input['password'])) ) {
            	Session::put('username', Crypt::encrypt($input['email']));
            	return Redirect::intended();
            } else {
            	return Redirect::route('login')->withInput(Input::only('email'))->withErrors('Gegevens incorrect. Controleer uw gegevens');
            }
        
        } catch ( ValidationException $e ) {
        	va_dump('hier?'); die();
            return Redirect::route( 'login' )->withInput(Input::only('email'))->withErrors( $e->get_errors() );
        }
	}

	public function getLogout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::route('home');
	}
}