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
        'status',
        'message',
        'user_id',
        'paymentId'.
        'token',
        'code',
        'total'
    ];
    /**
     * user one to one relationship
     */
    function user(){

        return  $this->belongsTo('App\User','foreign_key');
    }


}
