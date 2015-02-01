<?php namespace Kplus\Front\Controllers;

use View;
use Kplus\Models\Product;

class StockController extends \BaseController 
{
	public function getIndex()
	{
		$view = View::make('kplus.stock.IndexView');
		$view->title = 'Voorraadbeheer';
		$view->pageTitle = 'Voorraadbeheer';

		$view->subTitle = 'Voorraad overzicht';

		$products = Product::paginate(20);

		$view->products = $products;
		return $view;
	}

	/**
	 * show, loads up an extra view for the product edit
	 * @param  [type] $product_id [description]
	 * @return [type]             [description]
	 */
	public function show($product_id)
	{
		$view = View::make('kplus.stock.include.EditView');
		$product = Product::findOrFail($product_id);
		$view->product = $product;
		return $view;
	}

	/**
	 * create, loads up the create view for the product
	 * 
	 * @return [type] [description]
	 */
	public function create(){
		$view = View::make('kplus.stock.include.CreateView');

		return $view;
	}
}