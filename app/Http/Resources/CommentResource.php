<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
        return [
            'id' => $this->id,
            'msg' => $this->msg,
            'rate' => $this->rate,
            'negative' => $this->negative == null ? [] : explode('$$$___$$$', $this->negative),
            'positive' => $this->positive == null ? [] : explode('$$$___$$$', $this->positive),
            'status' => $this->status,
            'user' => $user->first_name . ' ' . $user->last_name,
            'created_at' => Controller::MiladyToShamsi($this->created_at),
            'confirmed_at' => $this->confirmed_at == null ? null : Controller::MiladyToShamsi($this->confirmed_at),
        ];
    }
}
