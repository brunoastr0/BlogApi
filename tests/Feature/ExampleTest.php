<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_post_has_slug()
    // {
    //     $post = Post::factory()->create(['title' => 'The Empire Strikes Back']);
    //     $this->assertEquals($post->slug, 'the-empire-strikes-back');
    // }
}
