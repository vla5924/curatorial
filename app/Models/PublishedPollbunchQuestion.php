<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedPollbunchQuestion extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->hasOne(Group::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function question()
    {
        return $this->hasOne(PollbunchQuestion::class);
    }
}
