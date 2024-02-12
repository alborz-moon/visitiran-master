<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'img' => $this->img == null ? asset('default.png') : asset('storage/products/' . $this->img),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'tags' => $this->tags,
            'alt' => $this->alt,
            'digest' => $this->digest,
            'seller_id' => $this->seller_id,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'available_count' => $this->available_count,
            'is_in_top_list' => $this->is_in_top_list,
            'visibility' => $this->visibility,
            'priority' => $this->priority,
            'price' => $this->price,
            'guarantee' => $this->guarantee,
            'introduce' => $this->introduce
        ];
    }
}
