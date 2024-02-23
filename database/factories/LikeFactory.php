<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition():array
    {
        return [
            "likeable_type" => Post::class,
            "likeable_id"=>Post::factory()->create()->id,
            "userable_type"=>User::class,
            "userable_id"=>User::factory()->create()->id,
            "is_liked"=>true
        ];
    }
}
