<?php

class CartLine extends \Eloquent {

    protected $table = 'cart_lines';
	protected $fillable = [];

    public function cart()
    {
        return $this->belongsTo('Cart');
    }

    public function product()
    {
        return $this->belongsTo('Product');
    }

}