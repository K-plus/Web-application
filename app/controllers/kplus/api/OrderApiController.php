<?php namespace Kplus\Api\Controllers;

use Auth;
use Kplus\Models\Order;
use Kplus\Models\OrderLine;
use Kplus\Models\CartLine;

class OrderApiController extends ApiController {

    public function createOrder()
    {
        // read cart
        $user = Auth::user();
        $cart = $user->cart;
        $cartLines = $cart->cartLines;

        // create order
        $order = new Order;
        $order->user_id = $user->id;
        $order->paid = 1;
        $order->save();

        $orderId = $order->id;

        // insert order lines
        if(count($cartLines))
        {
            $totalPrice = 0;

            foreach($cartLines as $c => $cartLine){
                $orderLine = new OrderLine;
                $orderLine->order_id = $orderId;
                $orderLine->ean = $cartLine->product->ean;
                $orderLine->product_name = $cartLine->product->name;
                $orderLine->qty = $cartLine->qty;
                $orderLine->unit_price = $cartLine->product->price;
                $orderLine->subtotal = ($cartLine->qty * $cartLine->product->price);
                $orderLine->save();

                // remove cart line
                $cartLine = CartLine::find($cartLine->id);
                $cartLine->delete();

                $totalPrice += $orderLine->subtotal;
            }

            $order = Order::find($orderId);
            $order->total_price = $totalPrice;
            $order->save();

            return $this->respondOk('Order created.');
        }
        else
        {
            return $this->respondValidationError('Cart has no cart lines.');
        }
    }

}