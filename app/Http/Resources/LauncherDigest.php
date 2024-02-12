<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LauncherDigest extends JsonResource
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
            'alt' => $this->alt,
            'img' => $this->img == null ? asset('storage/launchers/default.png') : asset('storage/launchers/' . $this->img),
            'back_img' => $this->back_img == null ? asset('storage/launchers/default.png') : asset('storage/launchers/' . $this->back_img),
            'keywords' => $this->keywords,
            'seo_tags' => $this->seo_tags,
            'digest' => $this->digest,
            'about' => $this->about,
            'rate' => $this->rate == null ? 4 : $this->rate,
            'rate_count' => $this->rate_count,
            'follower_count' => $this->follower_count,
            'company_name' => $this->company_name,
            'launcher_address' => $this->launcher_address,
            'launcher_email' => $this->launcher_email,
            'launcher_site' => $this->launcher_site,
            'launcher_phone' => $this->launcher_phone != null ? explode('__', $this->launcher_phone) : [],
            
            'address' => $this->launcher_address,
            'email' => $this->launcher_email,
            'site' => $this->launcher_site,
            'phone' => $this->launcher_phone != null ? explode('__', $this->launcher_phone) : [],

            'x' => $this->launcher_x,
            'y' => $this->launcher_y,
            
            'launcher_x' => $this->launcher_x,
            'launcher_y' => $this->launcher_y,
        ];
    }
}
