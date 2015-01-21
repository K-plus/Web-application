<?php

/**
 * Class Product
 */
class Product extends \Eloquent {
    /**
     * @var array
     */
    protected $fillable = ['name', 'price', 'ean'];
}