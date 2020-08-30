<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'message',
        'user_id',
        'payer_id'.
        'orderId',
        'statusCode',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'message' => 'array',
    ];

    /**
     * user one to one relationship
     */
    function user(){

        return  $this->belongsTo('App\User','foreign_key');
    }


}
