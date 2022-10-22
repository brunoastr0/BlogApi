<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

// use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'post' => $this->post,
            'slug' => $this->slug,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
