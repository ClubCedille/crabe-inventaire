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
        'paymentId'.
        'token',
        'total'
    ];

    /**
     * user one to one relationship
     */
    function user(){

        return  $this->belongsTo('App\User','foreign_key');
    }
}
