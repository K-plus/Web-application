<?php

use Kplus\Models\Store;

class StoreTableSeeder extends Seeder {

	public function run()
	{
		$store = new Store();

		$store->name = 'Hanze Hogeschool Groningen';
		$store->save();
    }
}