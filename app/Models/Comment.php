<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $attributes = [
        'title' => 'sample',
        'comment' => 'sample comment'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
