<?php namespace Kplus\Api\Controllers;

use Kplus\Models\Product;

class ProductApiController extends ApiController {

	public function show($id)
	{
        $product = Product::find($id);

        if( ! is_null($product))
        {
            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'ean' => $product->ean,
                'stock' => $product->stock
            ];

            return $this->respond([
                'data' => $productData
            ]);
        }
        else
        {
            return $this->respondNotFound('Product does not exist.');
        }



	}

}