<?php namespace Kplus\Models;

class Order extends \Eloquent {

    protected $table = 'orders';
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('Kplus\Models\User');
    }

    public function orderLines()
    {
        return $this->hasMany('Kplus\Models\OrderLine');
    }

}