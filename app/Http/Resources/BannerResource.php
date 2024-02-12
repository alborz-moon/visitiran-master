<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'href' => $this->href,
            'id' => $this->id,
            'section' => $this->section,
            'alt' => $this->alt,
            'img' => asset('storage/banner/' . $this->img)
        ];
    }
}
