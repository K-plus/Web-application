<?php namespace Kplus\Api\Controllers;

use Kplus\Models\Advertisement;
use Auth;
use Input;

class AdvertisementController extends ApiController 
{

	/**
	 * getAds gets the adds that are linekd to the store.
	 * @param  integer  $id 	The store id 
	 * @return  mixed
	 */
	public function getAdvertisement($id)
	{
		$ad = Advertisement::findOrFail($id);

		return $this->respond([
			'data' => $ad
		]);
	}
}