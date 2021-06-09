<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vk_id',
        'avatar',
        'education',
        'location',
        'notes',
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
        'settings' => AsArrayObject::class,
    ];

    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    public function pollbunches()
    {
        return $this->hasMany(Pollbunch::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function pointsNullifications()
    {
        return $this->hasMany(PointsNullification::class);
    }

    public function pointsAdjustments()
    {
        return $this->hasMany(PointsAdjustment::class);
    }

    public function cachedPoints()
    {
        return $this->hasMany(CachedPoints::class);
    }
}
