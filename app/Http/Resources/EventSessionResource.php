<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class EventSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $s = Controller::MiladyToShamsi2($this->start);
        $e = Controller::MiladyToShamsi2($this->end);

        return [
            'id' => $this->id,
            'start' => $s,
            'end' => $e,
        ];
    }
}
