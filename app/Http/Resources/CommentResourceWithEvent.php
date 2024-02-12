<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResourceWithEvent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $negative = $this->negative == null ? [] : explode('$$$___$$$', $this->negative);
        if(count($negative) == 1 && $negative[0] == "")
            $negative = [];
            
        $positive = $this->positive == null ? [] : explode('$$$___$$$', $this->positive);
        if(count($positive) == 1 && $positive[0] == "")
            $positive = [];

        $event = $this->event;
        return [
            'msg' => $this->msg,
            'rate' => $this->rate,
            'negative' => $negative,
            'positive' => $positive,
            'event' => $event->title,
            'img' => $event->img == null ? asset('default.png') : asset('storage/events/' . $this->img),
            'href' => route('event', ['event' => $event->id, 'slug' => $event->slug == null ? $event->title : $event->slug]),
            'created_at' => Controller::MiladyToShamsi2($this->created_at->timestamp)
        ];
    }
}
