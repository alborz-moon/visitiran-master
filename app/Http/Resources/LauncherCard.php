<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LauncherCard extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $events = $this->events()->get();
        $activeEvents = 0;
        $now = time();

        foreach($events as $event) {

            if($now > $event->end_registry) {
                $lastSession = $event->sessions()->orderBy('end', 'desc')->first();
                if($lastSession != null && $now > $lastSession->end)
                    continue;
            }
            $activeEvents++;

        }

        return [
            'id' => $this->id,
            'alt' => $this->alt,
            'img' => $this->img == null ? asset('storage/launchers/default.png') : asset('storage/launchers/' . $this->img),
            'rate' => $this->rate == null ? 4 : $this->rate,
            'follower_count' => $this->follower_count,
            'slug' => $this->company_name,
            'title' => $this->company_name,
            'active_events' => $activeEvents,
            'all_events' => count($events),
        ];
    }
}
