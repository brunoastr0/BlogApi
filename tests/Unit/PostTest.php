<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function test_post_has_slug()
    {
        $post = Post::factory()->create(['title' => 'The Empire Strikes Back']);

        $this->assertEquals('the-empire-strikes-back',$post->slug );
    }



    // }
}
