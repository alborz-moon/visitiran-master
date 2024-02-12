<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeadCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subs = $this->sub;
        if(count($subs) > 0)
            $subs = HeadCategoryResource::collection($subs)->toArray($request);
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subs' => $subs,
            'href' => route('single-category', ['category' => $this->id, 'slug' => $this->name]),
        ];
    }
}
