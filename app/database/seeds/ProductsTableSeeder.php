<?php

use Faker\Factory as Faker;
use Kplus\Models\Product;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        Product::create([
            'name' => 'Gehakt 500 gram',
            'price' => 289,
            'ean' => '0000000000001',
            'stock' => 78
        ]);

        Product::create([
            'name' => 'Doritos Nacho cheese',
            'price' => 117,
            'ean' => '0000000000002',
            'stock' => 45
        ]);

        Product::create([
            'name' => 'Hertog Jan Pilsener',
            'price' => 999,
            'ean' => '0000000000003',
            'stock' => 13
        ]);

//		foreach(range(1, 10) as $index)
//		{
//            $name = $faker->sentence(2);
//			Product::create([
//				'name' => substr($name, 0, strlen($name) - 1),
//				'price' => $faker->randomNumber(4),
//				'ean' => $faker->ean13,
//				'stock' => $faker->randomNumber(2),
//			]);
//		}
	}

}