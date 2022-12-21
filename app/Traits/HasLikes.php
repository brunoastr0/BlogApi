<?php
namespace App\Traits;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable')->where('is_liked', true);
    }    public function dislikes(): MorphMany
{
    return $this->morphMany(Like::class, 'likeable')->where('is_liked', false);
}
}
