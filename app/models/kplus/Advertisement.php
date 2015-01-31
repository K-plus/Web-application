<?php namespace Kplus\Models;

class Advertisement extends \Eloquent {

    protected $table = 'advertisements';
	protected $fillable = [];

    public function store()
    {
        return $this->belongsTo('Kplus\Models\Store');
    }

    public function product()
    {
        return $this->hasMany('Kplus\Models\Product');
    }

}