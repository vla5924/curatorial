<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollbunchQuestion extends Model
{
    use HasFactory;

    public function pollbunch()
    {
        return $this->belongsTo(Pollbunch::class);
    }

    public function answers()
    {
        return $this->hasMany(PollbunchAnswer::class);
    }
}
