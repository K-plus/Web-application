<?php namespace Kplus\Transformers;

/**
 * Class Transformer
 * @package Kplus\Transformers
 */
abstract class Transformer {

	/**
	 * Transform a collection of items
	 *
	 * @param $items
	 * @return array
	 */
	public function transformCollection($items)
	{
		return array_map([$this, 'transform'], $items);
	}

    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item);

}