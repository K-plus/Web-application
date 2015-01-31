<?php namespace Kplus\Models;

/**
 * Class Product
 */
class Product extends \Eloquent {
    /**
     * @var array
     */
    protected $fillable = ['name', 'price', 'ean', 'stock'];
}