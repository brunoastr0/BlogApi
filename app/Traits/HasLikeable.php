<?php
namespace App\Traits;

use App\Interfaces\Likeable;
use App\Models\Like;

trait HasLikeable
{
    public function like(Likeable $likeable, $state = true)
    {
        if ($like = $likeable->likes()->whereMorphedTo('userable', $this)->first()) {
            $like->update([
                'is_liked' => $state
            ]);

            return;
        }

        app(Like::class)
            ->userable()->associate($this)
            ->likeable()->associate($likeable)
            ->fill([
                'is_liked' => $state
            ])
            ->save();
    }

    public function unlike(Likeable $likeable)
    {
        $likeable->likes()
            ->whereMorphedTo('userable', $this)
            ->delete();
    }

    public function dislike(Likeable $likeable)
    {
        $this->like($likeable, false);
    }
}
