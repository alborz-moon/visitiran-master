<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'img' => $this->img == null ? asset('default.png') : asset('storage/blogs/' . $this->img),
            'header' => $this->header,
            'keywords' => $this->keywords,
            'digest' => $this->digest,
            'description' => $this->description,
            'visibility' => $this->visibility,
            'priority' => $this->priority,
            'tags' => $this->tags,
            'article_tags' => $this->article_tags,
            'alt' => $this->alt,
            'slug' => $this->slug,
            'created_at' => Controller::getPersianDate($this->created_at)
        ];
    }
}
