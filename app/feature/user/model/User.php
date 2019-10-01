<?php

namespace App\feature\user\model;

use App\database\concerns\GenerateUuid;
use App\feature\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use GenerateUuid;

    protected $table = 'users';
    public $primaryKey = 'user_id';
    public $keyType = "string";
    public $incrementing = false;
    public $casts = array(
        'user_id' => 'string',
        'name' => 'string',
        'email' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

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

    public function userCompany()
    {
        return $this->hasMany(UserCompany::class, "user_company_id", "user_id");
    }

    public function company()
    {
        return $this->hasManyThrough(Company::class, UserCompany::class,  "user_id", "company_id", "user_id", "company_id");
//        return $this->belongsTo(UserCompany::class, "user_id", "user_id");
//        return $this->morphMany(UserCompany::class, "user");
    }

//    public function company() {
//        return $this->hasMany(UserCompany::class, "user_company_id", "user_id");
//    }
}
