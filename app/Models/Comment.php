<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";
    protected $fillable = [
        "author_id",
        "post_id",
        "content",
        "posted_at"
    ];

    protected $dates = [
        'posted_at'
    ];


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
