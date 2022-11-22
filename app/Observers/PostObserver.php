<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $Post
     * @return void
     */
    public function creating(Post $post)
    {
        //

        $post->author_id = auth()->id();
    }
}
