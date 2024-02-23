<?php

namespace Tests\Feature\Post;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_like_post():void{
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create();
        $response = $this->postJson(route("post.like",$post->id))
            ->assertOk()
            ->json();
//        dd($response);

        $this->assertDatabaseHas("likes", [
            "likeable_type"=>Post::class,
            "likeable_id"=>$post->id,
            "userable_type"=>User::class,
            "userable_id"=>$this->user->id,
            "is_liked"=>true
            ]);


    }

    public function test_user_can_unlike_post():void{
        Sanctum::actingAs($this->user);

        $post = Post::factory()->create();
        $like = Like::factory()->create([
            "likeable_type"=>Post::class,
            "likeable_id"=>$post->id,
            "userable_type"=>User::class,
            "userable_id"=>$this->user->id
        ]);

       $this->postJson(route("post.unlike",$post->id))
            ->assertOk()
            ->json();

        $this->assertDatabaseMissing("likes", [
            "id"=>$like->id
        ]);
    }

   /* public function test_get_current_user_likes():void{
        Sanctum::actingAs($this->user);
        $like = Like::factory()->create([
            "userable_id"=>$this->user
        ]);

        $response = $this->getJson(route("user.likes"))
//            ->json()
        ->assertOk();
        dd($response);

    }*/

    public function test_get_likes_count_from_post():void{
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create();
        Like::factory()->create([
            "likeable_id"=>$post->id
        ]);
        Like::factory()->create([
            "likeable_id"=>$post->id
        ]);
       $response =  $this->getJson(route("post.like.count",$post->id))
            ->assertOk()
           ->json();
       $this->assertEquals(2,$response['likes_count']);

   }



}
