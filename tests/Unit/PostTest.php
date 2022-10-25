<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_post_has_slug()
    {
        $post = Post::factory()->create(['title' => 'The Empire Strikes Back']);
        $this->assertEquals($post->slug, 'the-empire-strikes-back');
    }

    // public function test_post_has_author()
    // {
    //     $post = Post::factory()->create();
    //     $user = User::factory()->create();



    // }
}