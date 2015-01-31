<?php

use Kplus\Models\Advertisement;

class AdvertisementsTableSeeder extends Seeder {

	public function run()
	{
		$ad = new Advertisement();

		$ad->store_id = 1;
		$ad->text = 'Gehakt 500 gram 2 euro!!';
		// $ad->product_id = 1;
		$ad->save();
    }

}