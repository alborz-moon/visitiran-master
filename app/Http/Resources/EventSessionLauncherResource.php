<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class EventSessionLauncherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $s = Controller::MiladyToShamsi3($this->start);
        $e = Controller::MiladyToShamsi3($this->end);

        return [
            'id' => $this->id,
            'start' => $s,
            'end' => $e,
        ];
    }
}
