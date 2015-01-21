<?php

class ShopsTableSeeder extends Seeder {

	public function run()
	{
        $shops = ['Groningen', 'Assen', 'Emmen', 'Zuidlaren', 'Delfzijl'];

		foreach($shops as $shop)
		{
			Shop::create([
                'name' => 'K-plus ' . $shop
			]);
		}
	}

}