<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'visibility' => $this->visibility,
            'priority' => $this->priority,
            'alt' => $this->alt,
            'img_large' => asset('storage/slider/' . $this->img_large),
            'img_mid' => $this->img_mid !== null ? asset('storage/slider/' . $this->img_mid) : null,
            'img_small' => $this->img_small !== null ? asset('storage/slider/' . $this->img_small) : null
        ];
    }
}
