<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class OffResource extends JsonResource
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
            'code' => $this->code,
            'user' => $this->user_id == null ? 'عمومی' : $this->user->first_name . ' ' . $this->user->last_name,
            'amount' => $this->amount,
            'off_type' => $this->off_type == 'percent' ? 'درصدی' : 'مقداری',
            'off_expiration' => Controller::convertStringToDate($this->off_expiration),
            'created_at' => Controller::MiladyToShamsi($this->created_at),
            'category' => $this->category_id == null ? 'عمومی' : $this->category->name,
            'brand' => $this->brand_id == null ? 'عمومی' : $this->brand->name,
            'seller' => $this->seller_id == null ? 'عمومی' : $this->seller->name,
        ];
    }
}
