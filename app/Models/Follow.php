<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    public function FollowerDetail(){   // The detail who else are following at user
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function FollowingDetail(){  // The detail who else are getting follow by user
        return $this->belongsTo(User::class, 'following', 'id');
    }
}
