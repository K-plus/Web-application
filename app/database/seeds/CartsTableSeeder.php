<?php

use Faker\Factory as Faker;
use Kplus\Models\Cart;
use Kplus\Models\CartLine;

class CartsTableSeeder extends Seeder {

	public function run()
	{
        Cart::create([
            'user_id' => 1
        ]);
        Cart::create([
            'user_id' => 2
        ]);
        Cart::create([
            'user_id' => 3
        ]);
        Cart::create([
            'user_id' => 4
        ]);

        CartLine::create([
            'cart_id' => 1,
            'product_id' => 1,
            'qty' => 3
        ]);
        CartLine::create([
            'cart_id' => 1,
            'product_id' => 2,
            'qty' => 1
        ]);
        CartLine::create([
            'cart_id' => 2,
            'product_id' => 2,
            'qty' => 2
        ]);
        CartLine::create([
            'cart_id' => 3,
            'product_id' => 1,
            'qty' => 1
        ]);
        CartLine::create([
            'cart_id' => 4,
            'product_id' => 3,
            'qty' => 5
        ]);


//		$faker = Faker::create();
//
//		foreach(range(1, 10) as $index)
//		{
//			Cart::create([
//
//			]);
//
//
//		}
	}

}