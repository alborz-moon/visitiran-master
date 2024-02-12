<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'x' => $this->x,
            'y' => $this->y,
            'city_id' => $this->city_id,
            'is_default' => $this->is_default,
            'state_id' => $this->city->state->id,
            'recv_name' => $this->recv_name,
            'recv_phone' => $this->recv_phone,
            'recv_last_name' => $this->recv_last_name,
        ];
    }
}
