<?php namespace Kplus\Models;

class CartLine extends \Eloquent {

    protected $table = 'cart_lines';
	protected $fillable = [];

    public function cart()
    {
        return $this->belongsTo('Kplus\Models\Cart');
    }

    public function product()
    {
        return $this->belongsTo('Kplus\Models\Product');
    }

}