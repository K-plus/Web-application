<?php namespace Kplus\Front\Controllers;

use View, Auth;
use JavaScript;
use Kplus\Models\Order;
use Kplus\Models\Cart;

class HomeController extends \BaseController {

	public function getIndex()
	{
		$view = View::make('kplus.home.IndexView');

		$view->title = 'Overzicht';
		$view->pageTitle = 'Overzicht';
		$view->subTitle = 'Recente activiteiten';

		// if(Auth::check()){
		// 	$orders = Order::where('user_id', '=', Auth::user()->id)->get()->sortBy('created_at');
		// 	$cart = Cart::where('user_id', '=', Auth::user()->id)->first();

		// 	$orderLinesArray = array();
		// 	foreach($orders as $order) {
		// 		foreach($order->orderLines as $orderLine){
		// 			$orderLinesArray[$order['id']][] = $orderLine; 
		// 		}
		// 	}

		// 	$cartLinesArray = array();
		// 	foreach($cart->cartLines as $cartLine){
		// 		$cartLinesArray[] = $cartLine->toArray();
		// 	}
			
		// } else {
		// 	$cart = null;
		// 	$orders = null;
		// }
			
		// $totalInCart = 0;
		// $totalPriceInCart = 0;

		// $totalOrders = 0;
		// $toalPriceOrders = 0;

	
		// $view->cartLines = $cartLinesArray;
		// $view->cart = $cart;
		// $view->orders = $orders;
		// $view->orderLines = $orderLinesArray;

		return $view; 
	}

}
