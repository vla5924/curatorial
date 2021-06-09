<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedPoints extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cached_points';

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function group()
    {
        $this->hasOne(Group::class);
    }
}
