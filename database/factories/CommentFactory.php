<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{

    public function definition()
    {
        return [
            "author_id"=>User::factory()->create(),
            "post_id"=>Post::factory()->create(),
            "content"=>$this->faker->paragraph,
        ];
    }
}
