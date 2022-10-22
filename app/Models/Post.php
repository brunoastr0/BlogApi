<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory, HasAuthor;
    // use Sluggable;

    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author_id'
    ];



    protected $dates = [
        'posted_at'
    ];

    protected $createdBy = [
        "author"
    ];

    protected static function booted()
    {

        static::saving(function ($post) {
            $post->slug = Str::slug($post->title, '-');
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
