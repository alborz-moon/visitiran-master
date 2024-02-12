<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

class EventUserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $start_registry_formatted = Controller::MiladyToShamsi3($this->start_registry);
        $end_registry_formatted = Controller::MiladyToShamsi3($this->end_registry);

        $start_formatted = Controller::MiladyToShamsi2($this->start);
        $end_formatted = Controller::MiladyToShamsi2($this->end);

        $start_registry = date("Y/m/d H:i", $this->start_registry);
        $end_registry = date("Y/m/d H:i", $this->end_registry);
        $start = date("Y/m/d H:i", $this->start);
        $end = date("Y/m/d H:i", $this->end);

        $sr = Controller::MiladyToShamsi($start_registry, '/');
        $er = Controller::MiladyToShamsi($end_registry, '/');
        $s = Controller::MiladyToShamsi($start, '/');
        $e = Controller::MiladyToShamsi($end, '/');
        
        $launcher = $this->launcher;
        
        return [
            'id' => $this->id,
            'launcher_id' => $this->launcher_id,
            'launcher_title' => $launcher->title,
            'launcher_rate' => $launcher->rate == null ? 4 : $launcher->rate,
            'launcher_img' => $launcher->img == null ? asset('storage/launchers/default.png') : asset('storage/launchers/' . $launcher->img),
            'launcher_rate_count' => $launcher->rate_count,
            'launcher_follower_count' => $launcher->follower_count,
            'launcher_x' => $launcher->launcher_x,
            'launcher_y' => $launcher->launcher_y,

            'isActiveForRegistry' => Event::isActiveForRegistry($this), 

            'start' => $s,
            'end' => $e,

            'sr' => $start_registry_formatted,
            'er' => $end_registry_formatted,
            
            's' => $start_formatted,
            'e' => $end_formatted,
            
            'rate' => $this->rate == null ? 4 : $this->rate,
            'rate_count' => $this->rate_count,

            'start_registry' => $sr,
            'end_registry' => $er,
            'start_registry_time' => explode(' ', $start_registry)[1],
            'end_registry_time' => explode(' ', $end_registry)[1],
            'img' => $this->img != null ? asset('storage/events/' . $this->img) : asset('storage/events/default.img'),
            'title' => $this->title,
            'age_description' => $this->age_description,
            'level_description' => $this->level_description,
            'ticket_description' => $this->ticket_description,
            'tags' => explode('_', $this->tags),
            'language' => explode('_', $this->language),
            'facilities' => explode('_', $this->facilities),
            'type' => $this->city_id != null ? 'offline' : 'online',
            'address' => $this->address,
            'link' => $this->link,
            'site' => $this->site,
            'email' => $this->email,
            'phone' => $this->phone == null || empty($this->phone) ? null : explode('_', $this->phone),
            'price' => number_format($this->price, 0),
            'slug' => $this->slug == null ? $this->title : $this->slug,
            'digest' => $this->digest,
            'keywords' => $this->keywords,
            'seo_tags' => $this->seo_tags,
            'x' => $this->x,
            'y' => $this->y,
            'description' => $this->description,
            'city' => $this->city_id == null ? '' : $this->city->name
        ];
    }
}
