<?php namespace Kplus\Transformers;

/**
 * Class ProductTransformer
 * @package Kplus\Transformers
 */
class ProductTransformer extends Transformer {

    /**
     * @param $product
     * @return array
     */
    public function transform($product)
	{
		return [
			'name' => $product['name'],
			'price' => $product['price'],
			'ean' => $product['ean'],
			'stock' => $product['stock']
		];
	}

}