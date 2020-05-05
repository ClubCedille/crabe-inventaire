<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function clear()
    {
        return $this->products()->detach();
    }
    
}
