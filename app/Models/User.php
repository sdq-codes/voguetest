<?php

namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable,SoftDeletes, UuidGenerator, Authorizable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $fillable = [
        'name', 'email','phone_number','last_activity_entry','password', 'user_type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
      'email_verified','active'
    ];

    public $timestamps = [
      'last_activity_entry'
    ];

    public function activity(){
        return $this->hasMany(UserActivity::class);
    }

    public function userPermission() {
        return $this->hasMany(UserPermission::class);
    }
}
