<?php namespace Kplus\Models;

class Cart extends \Eloquent {

    protected $table = 'carts';
	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('Kplus\Models\User');
    }

    public function cartLines()
    {
        return $this->hasMany('Kplus\Models\CartLine');
    }

}