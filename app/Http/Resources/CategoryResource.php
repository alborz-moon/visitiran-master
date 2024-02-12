<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'alt' =>  $this->alt,
            'digest' =>  $this->digest,
            'keywords' =>  $this->keywords,
            'tags' =>  $this->tags,
            'priority' =>  $this->priority,
            'visibility' =>  $this->visibility,
            'show_in_first_page' => $this->show_in_first_page,
            'show_items_in_first_page' => $this->show_items_in_first_page,
            'parent_id' => $this->parent_id,
            'img' => $this->img == null ? asset('default.png') : asset('storage/categories/' . $this->img)
        ];
    }
}
