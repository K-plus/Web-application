<?php namespace Kplus\Api\Controllers;

use Auth, Input;
use Kplus\Models\Order;
use Kplus\Models\OrderLine;
use Kplus\Models\CartLine;
use Kplus\Models\Product;

class OrderApiController extends ApiController {

    public function createOrder()
    {
        // read cart
        $user = Auth::user();
        $cart = $user->cart;
        $cartLines = $cart->cartLines;

        $productsPaid = Input::get('products');
        
        // create order
        // $order = new Order;
        // $order->user_id = $user->id;
        // $order->paid = 1;
        // $order->total_price = 0; // update below
        // $order->save();

        // $orderId = $order->id;

        // insert order lines
        if(count($productsPaid))
        {
            $totalPrice = 0;

            foreach($productsPaid as $product){
                var_dump($product); 
                // $orderLine = new OrderLine;

                // $orderLine->order_id = $orderId;
                // $orderLine->ean = $cartLine->product->ean;
                // $orderLine->product_name = $cartLine->product->name;
                // $orderLine->qty = $cartLine->qty;
                // $orderLine->unit_price = $cartLine->product->price;
                // $orderLine->subtotal = ($cartLine->qty * $cartLine->product->price);
                // $orderLine->save();

                // // update stock
                // $product = Product::find($cartLine->product->id);
                // $product->stock = $product->stock - $cartLine->qty;
                // $product->save();

                // // remove cart line
                // $cartLine = CartLine::find($cartLine->id);
                // $cartLine->delete();

                // $totalPrice += $orderLine->subtotal;
            }
        }
            // $order = Order::find($orderId);
            // $order->total_price = $totalPrice;
            // $order->save();

            // return $this->respondOk($productsPaid);
        // }
        // else
        // {
        //     return $this->respondValidationError('Cart has no cart lines.');
        // }
    }

}