<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

class EventPhase1Resource extends JsonResource
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
            'title' => $this->title,
            'age_description' => $this->age_description,
            'level_description' => $this->level_description,
            'tags' => explode('_', $this->tags),
            'language' => explode('_', $this->language),
            'facilities' => explode('_', $this->facilities),
            'type' => $this->city_id != null ? 'offline' : 'online',
            'x' => $this->x,
            'y' => $this->y,
            'city_id' => $this->city_id,
            'state_id' => $this->city_id != null ? City::whereId($this->city_id)->first()->state_id : null,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'link' => $this->link,
        ];
    }
}
