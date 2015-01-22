<?php

class Cart extends \Eloquent {

    protected $table = 'carts';
	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function cartLines()
    {
        return $this->hasMany('CartLine');
    }

}