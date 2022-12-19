<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

// use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'comments' =>  CommentRessource::collection($this->comments),
            'author' => new AuthorResource($this->author),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
