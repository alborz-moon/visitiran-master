<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMailResource extends JsonResource
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
            'mail' => $this->mail,
            'created_at' => Controller::MiladyToShamsi($this->created_at),
            'received' => $this->mails()->count()
        ];
    }
}
