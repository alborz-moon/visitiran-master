<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDigestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = $this->items();
        $transaction = $this->transaction;

        $images = [];
        foreach($items as $item)
            array_push($images, asset('storage/products/' . $item->img));

        return [
            'id' => $this->id,
            'created_at' => Controller::MiladyToShamsi3($this->created_at->timestamp),
            'total' => number_format($transaction->amount),
            'tracking_code' => $transaction->tracking_code,
            'items_count' => count($items),
            'images' => $images
        ];
    }
}
