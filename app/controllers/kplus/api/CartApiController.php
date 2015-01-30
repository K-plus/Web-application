<?php namespace Kplus\Api\Controllers;

use Auth;
use Input;
use Kplus\Models\CartLine;

/**
 * CartApiController handles API requests 
 */
class CartApiController extends ApiController {

    public function index()
    {
        $cart = Auth::user()->cart;

        // Check if the user has a cart
        if( ! is_null($cart) ) {
            $lines = [];
            $totalItems = 0;
            $totalPrice = 0;
            $cartLines = $cart->cartLines;

            foreach($cartLines as $c => $cartLine){
                
                $lines[$c]['id'] = $cartLine->id;
                $lines[$c]['qty'] = $cartLine->qty;
                
                $lines[$c]['product'] = [
                    'id' => $cartLine->product->id,
                    'name' => $cartLine->product->name,
                    'price' => $cartLine->product->price,
                    'ean' => $cartLine->product->ean
                ];

                $totalItems += $cartLine->qty;
                $totalPrice += ($cartLine->qty * $cartLine->product->price);
            }

            return $this->respond([
                'data' => [
                    'cart_id' => $cart->id,
                    'total_items' => $totalItems,
                    'total_price' => $totalPrice,
                    'cart_lines' => $lines
                ]
            ]);
        }

        // User does not have a cart yet. 
        return $this->respondOk('No cart present');
    }

    public function addProduct()
    {
        if (Input::has('id'))
        {
            $user = Auth::user();
            $cart = $user->cart;
            $productId = Input::get('id');
            $qty = Input::get('qty', 1);

            // check product already exist
            $cartLine = CartLine::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->first();

            if (is_null($cartLine))
            {
                $cartLine = new CartLine;
                $cartLine->cart_id = $cart->id;
                $cartLine->product_id = $productId;
                $cartLine->qty = $qty;
                $cartLine->save();
            }
            else
            {
                $cartLine->qty = $cartLine->qty + $qty;
                $cartLine->save();
            }

            return $this->respondOk('Product added to cart.');
        }
        else
        {
            return $this->respondValidationError('Parameters failed validation.');
        }
    }

    public function updateProduct()
    {
        if (Input::has('id') && Input::has('qty'))
        {
            $user = Auth::user();
            $cart = $user->cart;
            $productId = Input::get('id');
            $qty = max(1, Input::get('qty'));

            // check product already exist
            $cartLine = CartLine::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ( ! is_null($cartLine)) {
                $cartLine->qty = $cartLine->qty + $qty;
                $cartLine->save();

                return $this->respondOk('Product qty updated.');
            }
            else
            {
                return $this->respondNotFound('Product not exist on cart.');
            }
        }
        else
        {
            return $this->respondValidationError('Parameters failed validation.');
        }
    }

    public function substractProduct()
    {
        if (Input::has('id') && Input::has('qty'))
        {
            $user = Auth::user();
            $cart = $user->cart;
            $productId = Input::get('id');
            $qty = max(1, Input::get('qty'));

            // check product already exist
            $cartLine = CartLine::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ( ! is_null($cartLine)) {
                if($cartLine->qty == 1) {
                    $cartLine->delete();
                    return $this->respondOk('Product deleted from cart.');
                } else  {
                    $cartLine->qty = $cartLine->qty - $qty;
                    $cartLine->save();

                    return $this->respondOk('Product qty updated.');
                }
            }
            else
            {
                return $this->respondNotFound('Product not exist on cart.');
            }
        }
        else
        {
            return $this->respondValidationError('Parameters failed validation.');
        }
    }

    public function deleteProduct()
    {
        if (Input::has('id'))
        {
            $user = Auth::user();
            $cart = $user->cart;
            $productId = Input::get('id');

            $cartLine = CartLine::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ( ! is_null($cartLine)) {
                $cartLine->delete();
            }

            return $this->respondOk('Product deleted from cart.');
        }
        else
        {
            return $this->respondValidationError('Parameters failed validation.');
        }
    }

}