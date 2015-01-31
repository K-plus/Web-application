<?php namespace Kplus\Front\Controllers;

class OrderController extends \BaseController 
{
	public function getIndex()
	{
		$view = View::make('kplus.orders.IndexView');

		return $view;
	}
}