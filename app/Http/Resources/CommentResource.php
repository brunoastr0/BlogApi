<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'content' => $this->content,
            'author' => new AuthorResource($this->author),
            'post'=>$this->post_id,
            'created_at' => $this->created_at
        ];
    }
}
