<?php namespace Kplus\Api\Controllers;

use Kplus\Models\Product;
use Input;

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

    public function create()
    {
        $input = Input::only('product_name', 'product_price', 'product_qty', 'product_ean');

        if(count($input) != 0){

            $product = new Product();
            $product->name = $input['product_name'];
            $product->price = $input['product_price'];
            $product->stock = $input['product_qty']; 
            $product->ean = $input['product_ean'];
            $product->save();

            return $this->respondOk('Product created');

        } else {
            return $this->respondValidationError('No parameters');
        }

    }

    public function update($product_id)
    {
        $input = Input::only('product_name', 'product_price', 'product_qty', 'product_ean');

        if(count($input) != 0)
        {
            $product = Product::findOrFail($product_id);
            $product->update(array('ean' => $input['product_ean'], 'price' => $input['product_price'], 'stock' => $input['product_qty'], 'name' => $input['product_name']));
            return $this->respondOk('Product updated');
        }
        else
        {
            return $this->respondValidationError('No parameters');
        }
    }

    public function delete($product_id)
    {
        $product = Product::findOrFail($product_id);

        if($product !== null){
            $product->delete();
            return $this->respondOk('Product deleted');
        } else {
             return $this->respondValidationError('STUUR DAN EEN ID MEE');
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