<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LauncherFilesResource extends JsonResource
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
            'company_newspaper' => $this->company_newspaper == null ? '' : asset('storage/launchers/' . $this->company_newspaper),
            'company_last_changes' => $this->company_last_changes == null ? '' : asset('storage/launchers/' . $this->company_last_changes),
            'user_NID_card' => $this->user_NID_card == null ? '' : asset('storage/launchers/' . $this->user_NID_card),
            'certifications' => CertificateResource::collection($this->certs)->toArray($request)
        ];
    }
}
