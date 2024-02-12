<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class commentResourceWithProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $negative = $this->negative == null ? [] : explode('$$$___$$$', $this->negative);
        if(count($negative) == 1 && $negative[0] == "")
            $negative = [];
            
        $positive = $this->positive == null ? [] : explode('$$$___$$$', $this->positive);
        if(count($positive) == 1 && $positive[0] == "")
            $positive = [];

        $product = $this->product;
        return [
            'msg' => $this->msg,
            'rate' => $this->rate,
            'negative' => $negative,
            'positive' => $positive,
            'product' => $product->name,
            'img' => $this->img == null ? asset('default.png') : asset('storage/products/' . $this->img),
            'href' => route('single-product', ['product' => $product->id, 'slug' => $product->slug == null ? $product->name : $product->slug]),
            'created_at' => Controller::MiladyToShamsi($this->created_at)
        ];
    }
}
