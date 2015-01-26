<?php namespace Kplus\Front\Controllers;

use View;
use JavaScript;

class HomeController extends \BaseController {

	public function getIndex()
	{
		$view = View::make('kplus.home.IndexView');

		$view->title = 'Home';

		JavaScript::put([
			
		]);

		return $view; 
	}

}
