<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => AsArrayObject::class,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
