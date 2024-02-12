<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $childs = $this->sub()->count();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alt' =>  $this->alt,
            'digest' =>  $this->digest,
            'priority' =>  $this->priority,
            'visibility' =>  $this->visibility,
            'has_sub' => $childs > 0,
            'products_count' => $childs > 0 ? 0 : $this->products()->count(),
            'features_count' => $childs > 0 ? 0 : $this->features()->count(),
            'childs_count' => $childs,
            'parent_id' => $this->parent_id,
            'img' => $this->img == null ? asset('default.png') : asset('storage/categories/' . $this->img),
            'href' => route('single-category', ['category' => $this['id'], 'slug' => $this['name']]),
        ];
    }
}
