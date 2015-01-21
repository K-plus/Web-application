<?php

use Faker\Factory as Faker;

class ShopProductStockTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $productIds = Product::lists('id');
        $shopIds = Shop::lists('id');

		foreach($productIds as $productId)
		{
			foreach($shopIds as $shopId)
            {
                DB::table('shop_product_stock')->insert([
                    'product_id' => $productId,
                    'shop_id' => $shopId,
                    'stock' => $faker->randomNumber(2)
                ]);
            }
		}
	}

}