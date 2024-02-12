<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class LauncherResourceAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $user = $this->user;
        $userId = $this->user_id;

        if($user == null) {
            $name = '';
            $phone = $this->phone;
            $status = 'active';

        }
        else {
            $name = $user->first_name != null && $user->last_name != null ? 
                $user->first_name . ' ' . $user->last_name : '';
            $phone = $user->phone;
            $status = $user->status;
        }

        return [
            'id' => $this->id,
            'created_at' => Controller::getPersianDate($this->created_at),
            'user' => [
                'name' => $name,
                'phone' => $phone,
                'id' => $userId
            ],
            'name' => $this->first_name . ' ' . $this->last_name,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'type' => $this->launcher_type,
            'launcher_status' => $this->status,
            'user_status' => $status,
            'followers_count' => $this->followers_count,
            'seen' => $this->seen,
            'comment_count' => $this->comment_count,
            'new_comment_count' => $this->new_comment_count,
            'follower_count' => $this->follower_count,
            'confirmed_events_count' => $this->events()->confirmed()->count(),
            'active_events' => $this->events()->activeForRegistry()->count(),
            'rate' => $this->rate,
            'rate_count' => $this->rate_count,
        ];
    }
}
