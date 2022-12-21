<?php

namespace App\Models;

use App\Interfaces\Likeable;
use App\Traits\HasAuthor;
use App\Traits\HasLikes;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Post extends Model implements Likeable
{
    use HasFactory, HasAuthor, HasLikes;


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
        "author_id"
    ];

    protected static function booted()
    {

        static::saving(function ($post) {
            $post->slug = Str::slug($post->title, '-');
        });

        // static::addGlobalScope(new LastWeekScope());

    }
    public function scopeLastWeek(Builder $query, int $limit = 5)
    {
        $aWeekAgo = Carbon::now()->subDays(7)->endOfDay()->toDateTimeString();


        return  $query->whereBetween('created_at', [$aWeekAgo, now()])
            ->latest()
            ->limit($limit);
    }


    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        }
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
