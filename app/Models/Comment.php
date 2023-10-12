<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'email', 'text', 'parent_id', 'homepage_url'];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
