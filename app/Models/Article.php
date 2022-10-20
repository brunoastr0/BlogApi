<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    // use Sluggable;

    protected $table = 'posts';
    protected $fillable = [
        'title',
        'post',
        'slug',
        'author_id'
    ];

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }

    protected $dates = [
        'posted_at'
    ];

    protected $createdBy = [
        "author"
    ];

    protected static function booted()
    {
        static::creating(function ($article) {
            $article->author_id = auth()->id();
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
