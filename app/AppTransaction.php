<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppTransaction extends Model
{
    protected $table = 'app_transactions';
    protected $primaryKey = 'transaction_id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'statusCode'.
        'status',
        'orderId',
        'intent',
        'capture_id',
        'net_amount',
        'paypal_fee',
        'payer_id',
        'total',
        'products'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'products' => 'array',
    ];

    /**
     * user one to one relationship
     */
    public function user()
    {
        return  $this->belongsTo('App\User', 'user_id');
    }
}
