<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'membershipExpirationDate',
        'codeUniversel',
        'email',
        'password',
        'chipNumber'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'isAdmin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'membershipExpirationDate' => 'datetime',
    ];

    public function isMembershipActive()
    {
        return $this->membershipExpirationDate->greaterThanOrEqualTo(Carbon::now());
    }

    public function subscribeOneYear()
    {
        $this->membershipExpirationDate = Carbon::now()->addYear(1);
        $this->save();
    }

    public function subscribeFourYears()
    {
        $this->membershipExpirationDate = Carbon::now()->addYear(4);
        $this->save();
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function cart()
    {
        return $this->hasOne('App\Cart');
    }
}
