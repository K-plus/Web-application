<?php namespace Kplus\Front\Controllers;

use View;

class CartController extends \BaseController
{
	
	public function getIndex()
	{
		$view = View::make('kplus.cart.IndexView');

		$view->title = 'Kappalist';

		return $view;
	}
}