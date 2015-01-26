<?php namespace Kplus\Models;

class OrderLine extends \Eloquent {

    protected $table = 'order_lines';
    protected $fillable = [];

    public function order()
    {
        return $this->belongsTo('Kplus\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('Kplus\Models\Product');
    }

}