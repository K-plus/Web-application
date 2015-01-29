<?php namespace Kplus\Front\Controllers;

use View;

class StockController extends \BaseController 
{
	public function getIndex()
	{
		$view = View::make('kplus.stock.IndexView');
		$view->title = 'Voorraadbeheer';
		$view->pageTitle = 'Voorraadbeheer';

		$view->subTitle = '';

		return $view;
	}
}