<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArtcileTests extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_can_create_an_article()
    {

        $article = Article::create([
            "title" => fake()->text(),
            "post" => fake()->paragraph()
        ]);


        $response = $this->post('/post', $article);

        $response->assertStatus(200);
        $response->assertSee("Article created succesfully");
    }
}
