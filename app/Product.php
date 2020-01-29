<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category(){
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    protected $fillable = [
        'oode',
        'name',
        'description',
        'price',
        'category_id',
        'quantity'
    ];

    public function removeQuantity($quantityToSubtract){
        $this->quantity = $this->quantity - $quantityToSubtract;
        $this->save();
    }
}
