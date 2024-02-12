<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tmp = explode('$$', $this->value);
        $value = count($tmp) == 2 ? $tmp[0] : $this->value;
        $value = $this->unit == null ? $value : $value . ' ' . $this->unit;
        
        if($this->price !== null && !empty($this->price)) {

            $product = Product::find($this->product_id);
        
            $off = $product->activeOff($request->user == null ? null : $request->user->id);
            $tmp = explode('$$', $this->price);
            $pricesAfterOff = [];

            foreach($tmp as $itr) {
                $itr = (int)str_replace(',', '', $itr);
                if($off != null && $off['type'] === 'value')
                    array_push($pricesAfterOff, number_format($itr - $off['value'], 0));
                else if($off != null)
                    array_push($pricesAfterOff, number_format($itr * (100 - $off['value']) / 100, 0));
            }
          
            return [
                'id' => $this->id,
                'name' => $this->name,
                'pricesAfterOff' => implode('$$', $pricesAfterOff),
                'price' => $this->price,
                'available_count' => $this->available_count,
                'value' => $value,
                'label' => count($tmp) == 2 ? $tmp[1] : '',
                'show_in_top' => $this->show_in_top
            ];

        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'available_count' => $this->available_count,
            'value' => $value,
            'label' => count($tmp) == 2 ? $tmp[1] : '',
            'show_in_top' => $this->show_in_top
        ];
    }
}
