<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class PostResource extends JsonResource
{

    public function toArray($request):array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'comments' =>  CommentResource::collection($this->comments),
            'author' => new AuthorResource($this->author),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
