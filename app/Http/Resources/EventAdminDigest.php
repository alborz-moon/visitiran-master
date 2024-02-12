<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class EventAdminDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $launcher = $this->launcher;

        $start_registry = date("Y/m/d H:i", $this->start_registry);
        $end_registry = date("Y/m/d H:i", $this->end_registry);

        $sr = Controller::MiladyToShamsi($start_registry, '/');
        $er = Controller::MiladyToShamsi($end_registry, '/');

        return [
            'id' => $this->id,
            'created_at' => Controller::getPersianDate($this->created_at),
            'seen' => $this->seen,
            'tags' => $this->tags,
            'buyers' => $this->buyers()->count(),
            'city' => $this->city_id != null ? $this->city->name : '',
            'comment_count' => $this->comment_count,
            'new_comment_count' => $this->new_comment_count,
            'rate' => $this->rate,
            'rate_count' => $this->rate_count,
            'type' => $this->city_id != null ? 'offline' : 'online',
            'status' => $this->status,
            'launcher' => $launcher->company_name,
            'launcher_id' => $launcher->id,
            'registry' => $sr . ' تا ' . $er,
            'slug' => $this->slug,
            'priority' => $this->priority,
            'visibility' => $this->visibility,
            'is_in_top_list' => $this->is_in_top_list,
            'title' => $this->title,
            'price' => $this->price
        ];
    }
}
