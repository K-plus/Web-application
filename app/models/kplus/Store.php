<?php namespace Kplus\Models;

class Store extends \Eloquent {

    protected $table = 'stores';
	protected $fillable = [];

    public function ads()
    {
        return $this->belongsTo('Kplus\Models\Advertisement');
    }

    // public function products()
    // {
    //     return $this->hasMany('Kplus\Models\Product');
    // }

}