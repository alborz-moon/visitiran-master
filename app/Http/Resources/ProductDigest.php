<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDigest extends JsonResource
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
            'rate' => $this->rate,
            'name' => $this->name,
            'slug' => $this->slug,
            'brand' => $this->brand->name,
            'category' => $this->category->name,
            'available_count' => $this->available_count,
            'is_in_top_list' => $this->is_in_top_list,
            'visibility' => $this->visibility,
            'priority' => $this->priority,
            'price' => $this->price,
            'seller_count' => $this->seller_count,
            'created_at' => Controller::MiladyToShamsi($this->created_at),
            'rate_count' => $this->rate_count,
            'comment_count' => $this->comment_count,
            'new_comment_count' => $this->new_comment_count,
            'seen' => $this->seen,
            'has_effective_feature' => $this->productEffectiveFeatures() != null,
        ];
    }
}
