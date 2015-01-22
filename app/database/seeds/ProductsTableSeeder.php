<?php

use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder {

	public function run()
	{

		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
            $name = $faker->sentence(2);
			Product::create([
				'name' => substr($name, 0, strlen($name) - 1),
				'price' => $faker->randomNumber(4),
				'ean' => $faker->ean13,
				'stock' => $faker->randomNumber(2),
			]);
		}
	}

}