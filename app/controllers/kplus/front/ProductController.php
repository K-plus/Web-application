<?php namespace Kplus\Front\Controllers;

use Kplus\Models\Cart;
use Kplus\Models\Product; 

use View, Auth;

class ProductController extends \BaseController
{
	
	public function getIndex()
	{
		$view = View::make('kplus.product.IndexView');
		$view->title 		= 'Producten';
		$view->pageTitle 	= 'Producten';
		$view->subTitle 	= 'Doorzoek alle producten';

		$products = Product::paginate(10);

		$view->products 	= $products;
		return $view;
	}
}