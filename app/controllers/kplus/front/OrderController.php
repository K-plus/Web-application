<?php namespace Kplus\Front\Controllers;

use Kplus\Models\Order;
use View, Auth;

class OrderController extends \BaseController 
{
	public function getIndex()
	{
		$view = View::make('kplus.order.IndexView');
		$view->title = 'Bonnen';
		$view->pageTitle = 'Bonnen';
		$view->subTitle = 'Uw afgerekende bonnen';

		$userOrders = Auth::user()->orders;

		$view->orders = $userOrders->toArray();

		return $view;
	}

	public function show($order_id)
	{
		$view = View::make('kplus.order.include.OrderView');
		$order = Order::with('orderLines')->whereId($order_id)->first()->toArray();
		
		$totalQty = 0;
		$totalPrice = 0;

		foreach($order['order_lines'] as $orderLine){
			$totalQty += $orderLine['qty'];
			$totalPrice += $orderLine['subtotal'];
		}

		$view->order = $order;
		$view->totalPrice = $totalPrice;
		$view->totalQty = $totalQty;

		return $view;
	}
}