<?php

class CartApiController extends ApiController {

    public function index()
    {
        $user = Auth::user();

        $cart = $user->cart;
        $cartLines = $cart->cartLines;

        $lines = [];
        foreach($cartLines as $c => $cartLine){
            $lines[$c]['id'] = $cartLine->id;
            $lines[$c]['amount'] = $cartLine->amount;
            $lines[$c]['product'] = [
                'id' => $cartLine->product->id,
                'name' => $cartLine->product->name,
                'price' => $cartLine->product->price,
                'ean' => $cartLine->product->ean
            ];
        }

        return $this->respond([
            'data' => [
                'cart_id' => $cart->id,
                'cart_lines' => $lines
            ]
        ]);
    }

}