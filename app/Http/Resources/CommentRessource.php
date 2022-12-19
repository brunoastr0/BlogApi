<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentRessource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'content' => $this->content,
            'author' => new AuthorResource($this->author),
            'created_at' => $this->created_at
        ];
    }
}
