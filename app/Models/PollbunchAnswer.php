<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollbunchAnswer extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(PollbunchQuestion::class);
    }
}
