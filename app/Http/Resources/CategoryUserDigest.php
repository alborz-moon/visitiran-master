<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryUserDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!isset($this['id']))
            return [
                'id' => $this->id,
                'name' => $this->name,
                'href' => route('single-category', ['category' => $this->id, 'slug' => $this->name]),
                'alt' =>  $this->alt,
                'img' => $this->img == null ? asset('default.png') : asset('storage/categories/' . $this->img)
            ];

        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'href' => route('single-category', ['category' => $this['id'], 'slug' => $this['name']]),
            'alt' =>  $this['alt'],
            'img' => $this['img'] == null ? asset('default.png') : asset('storage/categories/' . $this['img'])
        ];
    }
}
