<?php namespace Kplus\Models;

class CartLine extends \Eloquent {

    protected $table = 'cart_lines';
	protected $fillable = ['cart_id', 'product_id', 'qty'];

    public function cart()
    {
        return $this->belongsTo('Kplus\Models\Cart');
    }

    public function product()
    {
        return $this->belongsTo('Kplus\Models\Product');
    }

}