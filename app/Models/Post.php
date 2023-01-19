<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function UploadBy()
    {
        return $this->belongsTo(User::class, 'upload_by', 'id');
    }

    public function Likers()
    {
        return $this->hasMany(Like::class, 'post_like', 'id');
    }

    public function Commentators()
    {
        return $this->hasMany(Comment::class, 'post_comment', 'id');
    }
}
