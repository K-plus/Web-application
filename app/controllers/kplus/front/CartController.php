<?php namespace Kplus\Front\Controllers;

use Kplus\Models\Cart;

use View, Auth;

class CartController extends \BaseController
{
	
	public function getIndex()
	{
		$cart = Auth::user()->cart;

		$user = Auth::user();

		if( is_null($cart) ) {
			$cart = new Cart();
			$cart->user_id = $user->id; 
			$cart->save();
			$cart = $cart;
		}

		$totalPrice = 0;
		$totalQty = 0;

		foreach( $cart->cartLines as $cartLine ) {
		
			$totalPrice += $cartLine->product->price * $cartLine->qty; 
		
			$totalQty += $cartLine->qty;

			$cartLine->product->toArray(); 
		}

		$view = View::make('kplus.cart.IndexView');
		$view->title 		= 'Boodschappenlijst';
		$view->cartItems 	= $cart->cartLines;
		$view->totalPrice	= $totalPrice; 
		$view->totalQty 	= $totalQty;
		$view->pageTitle 	= 'Boodschappenlijst';
		$view->subTitle 	= 'Artikelen op uw lijst';

		return $view;
	}
}