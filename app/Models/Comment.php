<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, HasAuthor;

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


    public function author():BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function post():BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
