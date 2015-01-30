<?php namespace Kplus\Api\Controllers;

use Kplus\Models\Product;

/**
 * Class ProductApiController
 * @package Kplus\Api\Controllers
 */
class ProductApiController extends ApiController {

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
	{
        $product = Product::find($id);

        if( ! is_null($product))
        {
            return $this->respond([
                'data' => $this->transformProduct($product)
            ]);
        }
        else
        {
            return $this->respondNotFound('Product does not exist.');
        }
	}

    /**
     * @param $term
     * @return mixed
     */
    public function search($term)
    {

        $products = Product::where('name', 'LIKE', '%'.$term.'%')
                    ->orWhere('ean', 'LIKE', '%'.$term.'%')
                    ->orWhere('price', 'LIKE', '%'.$term.'%')
                    ->get();

        if( count($products) != 0 )
        {
            $dataArray = array();

            foreach($products as $product) {
                $dataArray[] = $this->transformProduct($product);
            }
            
            return $this->respond([
                'data'=> $dataArray
            ]);
        }
        else
        {
            return $this->respondNotFound('Product not found.');
        }
    }

    /**
     * @param $product
     * @return array
     */
    private function transformProduct($product)
    {
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'ean' => $product->ean,
            'stock' => $product->stock
        ];
        return $productData;
    }
}