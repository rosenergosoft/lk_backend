<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    const LOGIN_TYPE_EMAIl = 'email';
    const LOGIN_TYPE_PHYS = 'phys';
    const LOGIN_TYPE_YUR = 'yur';
    const LOGIN_TYPE_IP = 'ip';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * @return HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Documents::class);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    /**
     * Load all necessary relations
     */
    public function fullLoad()
    {
        $this->load([
            'roles',
            'permissions',
            'profile',
            'company',
            'vendor'
        ]);
    }
}
