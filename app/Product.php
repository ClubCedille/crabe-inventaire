<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category(){
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'category_id',
        'quantity'
    ];

    public function updateQuantity($quanityToremove){ 
        $this->quantity = $this->quantity - $quanityToremove;
        $this->save();
    }
}
