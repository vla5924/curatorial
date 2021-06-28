<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vk_id',
        'alias',
        'vk_confirmation_token',
        'timetable_url',
    ];

    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    public function pollbunches()
    {
        return $this->hasMany(Pollbunch::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
