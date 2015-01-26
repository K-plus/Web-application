<?php namespace Kplus\Api\Controllers;

use Auth, Input;
use Kplus\Models\CartLine;

class CartApiController extends ApiController {

    public function index()
    {
        $cart = Auth::user()->cart;
        $cartLines = $cart->cartLines;

        $lines = [];
        $totalItems = 0;
        $totalPrice = 0;

        foreach($cartLines as $c => $cartLine){
            $lines[$c]['id'] = $cartLine->id;
            $lines[$c]['qty'] = $cartLine->qty;
            $lines[$c]['sub_total'] = ($cartLine->qty * $cartLine->product->price);
            $lines[$c]['product'] = [
                'id' => $cartLine->product->id,
                'name' => $cartLine->product->name,
                'price' => $cartLine->product->price,
                'ean' => $cartLine->product->ean
            ];

            $totalItems += $cartLine->qty;
            $totalPrice += $lines[$c]['sub_total'];
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
                $cartLine->qty = $cartLine->qt + $qty;
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