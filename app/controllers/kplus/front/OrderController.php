<?php namespace Kplus\Front\Controllers;

class OrderController extends \BaseController 
{
	public function getIndex()
	{
		$view = Viebew::make('kplus.orders.IndexView');

		return $view;
	}
}