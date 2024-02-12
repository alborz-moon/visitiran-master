<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $access = $this['access'];
        if($access == 'both')
            $accessFa = 'هر دو سایت';
        else if($access == 'event')
            $accessFa = 'سایت ایونت';
        else if($access == 'shop')
            $accessFa = 'سایت فروشگاه';

        return [
            'name' => $this['first_name'] . ' ' . $this['last_name'],
            'id' => $this['id'],
            'nid' => $this['nid'],
            'phone' => $this['phone'],
            'access_fa' => $accessFa,
            'access' => $access,
            'mail' => $this['mail'],
            'status' => $this['status'],
        ];
    }
}
