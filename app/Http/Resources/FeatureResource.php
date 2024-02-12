<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $choices = [];

        if($this->choices != null) {
            $tmp = explode('__', $this->choices);
            foreach($tmp as $itr) {
                $arr = explode('$$', $itr);
                if(count($arr) == 2) {
                    array_push($choices, [
                        'key' => $arr[0],
                        'label' => $arr[1]
                    ]);
                }
                else {
                    array_push($choices, [
                        'key' => $arr[0],
                        'label' => ''
                    ]);
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'show_in_top' => $this->show_in_top,
            'effect_on_price' => $this->effect_on_price,
            'effect_on_available_count' => $this->effect_on_available_count,
            'unit' => $this->unit,
            'answer_type' => $this->answer_type,
            'priority' => $this->priority,
            'choices' => $choices,
        ];
    }
}
