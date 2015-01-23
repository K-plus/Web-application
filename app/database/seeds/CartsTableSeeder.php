<?php

use Faker\Factory as Faker;

class CartsTableSeeder extends Seeder {

	public function run()
	{
        Cart::create([
            'user_id' => 1
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