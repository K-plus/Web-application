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

        $products = json_decode(Input::get('products'), true);
        
        // create order
        $order = new Order;
        $order->user_id = $user->id;
        $order->paid = 1;
        $order->total_price = 0; // update below
        $order->save();

        $orderId = $order->id;

        // insert order lines
        if(count($products))
        {
            $totalPrice = 0;

            foreach($products as $product){
                
                $productObject = Product::findOrFail($product['id']);

                $orderLine = new OrderLine;

                $orderLine->order_id = $orderId;
                $orderLine->ean = $productObject->ean;
                $orderLine->product_name = $productObject->name;
                $orderLine->qty = $product['quantity'];
                $orderLine->unit_price = $productObject->price;
                $orderLine->subtotal = ($product['quantity'] * $productObject->price);
                $orderLine->save();

                // update stock
                $productObject->stock = $productObject->stock - $product['quantity'];
                $productObject->save();

                foreach($cartLines as $cartLine){
                    if($cartLine->product_id == $product['id']){
                        if($cartLine->qty <= $product['quantity']){
                            $cartLine->delete();
                        } else {
                            $cartLine->qty -= $product['quantity'];
                            $cartLine->save();
                        }
                    }
                }

                $totalPrice += $orderLine->subtotal;
            }

            $order = Order::find($orderId);
            $order->total_price = $totalPrice;
            $order->save();

            return $this->respondOk("Kappa");
        }
        else
        {
            return $this->respondValidationError('Cart has no cart lines.');
        }
    }

}