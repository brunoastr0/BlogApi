<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class PostTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->john_doe()->create();
//        Sanctum::actingAs($this->user);
    }

    use RefreshDatabase;



    public function test_auth_user_can_create_post()
    {
        Sanctum::actingAs($this->user);
        $post = Post::factory()->make();
         $this->postJson(route('post.store'),$post->toArray())
            ->assertCreated();
        $this->assertDatabaseHas('posts',["title"=>$post->title]);


    }

    public function test_not_auth_user_cannot_create_post()
    {


        $post = Post::factory()->make();

            $this
                ->postJson(route('post.store'), $post->toArray())
         ->assertUnauthorized();
        $this->assertDatabaseMissing('posts',[$post->title]);
    }



    public function test_not_author_cannot_edit_post():void
    {
        Sanctum::actingAs($this->user);
        $user2 = User::factory()->create();
        $post = Post::factory()->create([
            "author_id" => $user2->id

        ]);
        $this->putJson(route("post.update",$post->id),['title'=>'updated'])
            ->assertUnauthorized();
            $this->assertDatabaseMissing('posts',['title'=>'updated']);

    }

    public function test_author_can_delete_post():void{
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create(['author_id'=>auth()->id()]);

        $this->deleteJson(route('post.destroy',$post->id))
            ->assertNoContent();
        $this->assertDatabaseMissing("posts",['slug'=>$post->slug]);
    }

    public function test_not_author_cannot_delete_post():void{
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create();

        $this->deleteJson(route('post.destroy',$post->id))
            ->assertUnauthorized();
        $this->assertDatabaseHas("posts",['slug'=>$post->slug]);
    }

    public function test_post_index_route():void{
        Post::factory()->create();
        Post::factory()->create();

        $this->getJson(route('post.index'))
            ->assertOk()
            ->assertJsonCount(2);

    }
}
