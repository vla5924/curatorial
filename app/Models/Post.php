<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function attachments()
    {
        return $this->hasMany(PostAttachment::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function signer()
    {
        return $this->belongsTo(User::class, 'signer_id');
    }

    public function pointsAssigner()
    {
        return $this->belongsTo(User::class, 'points_assigner_id');
    }
}
