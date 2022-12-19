<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_comment_can_be_added_to_post(){
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create();

        $comment = Comment::factory()->make(['post_id'=>$post->id]);

        $this->postJson(route('post.comment.store',$post->id),$comment->toArray())
            ->assertCreated();
        $this->assertDatabaseHas('comments',['post_id'=>$post->id,'content'=>$comment->content]);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
        $this-> assertEquals($comment->content,$post->comments->first()->content);

    }

    public function test_comment_author_can_delete_comment():void{
        Sanctum::actingAs($this->user);
        $user = User::factory()->john_doe()->create();
        $post = Post::factory()->create([
            "author_id"=>$user->id,
        ]);
        $comment = Comment::factory()->create([
            "author_id"=>$this->user->id,
            "post_id"=>$post->id
        ]);
        $this->deleteJson(route('post.comment.destroy',[$post->id,$comment->id]))
            ->assertNoContent();

        $this->assertDatabaseMissing('comments',['id'=>$comment->id]);
        $this->assertNull($post->comments->first());

    }
    public function test_post_author_can_delete_comment():void{
        Sanctum::actingAs($this->user);
        $user = User::factory()->john_doe()->create();
        $post = Post::factory()->create([
            "author_id"=>$this->user->id,
        ]);
        $comment = Comment::factory()->create([
            "author_id"=>$user->id,
            "post_id"=>$post->id
        ]);
        $this->deleteJson(route('post-comment.destroy',[$post->id,$comment->id]))
            ->assertNoContent();

        $this->assertDatabaseMissing('comments',['id'=>$comment->id]);
        $this->assertNull($post->comments->first());

    }

    public function test_post_comments_route_index():void{
        Sanctum::actingAs($this->user);
        $post = Post::factory()->create();
       Comment::factory()->create([
           'content'=>'ola b',
            'post_id'=>$post->id
        ]);
       Comment::factory()->create([
           'content'=>'ola',
            'post_id'=>$post->id
        ]);


        $response = $this->getJson(route('post.comment.index', $post->id))
            ->json();


    }

}
