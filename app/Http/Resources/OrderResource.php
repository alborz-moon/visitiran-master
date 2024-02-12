<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Purchase;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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

        $items = [];
        foreach($items as $item) {
            array_push($items, [
                'img' => asset('storage/products/' . $item->img),
                'title' => $item->name,
                'count' => $item->count,
                'unit_price' => $item->unit_price,
                'feature' => $item->feature,
                'id' => $item->id
            ]);
        }

        $status = 'در حال ارسال';
        if($this->status == Purchase::$FINALIZED)
            $status = 'مرجوعی';
        else if($this->status == Purchase::$DELIVERED)
            $status = 'تحویل شده';

        return [
            'id' => $this->id,
            'created_at' => Controller::MiladyToShamsi3($this->created_at->timestamp),
            'total' => number_format($transaction->amount),
            'total_off' => number_format($transaction->off_amount),
            'tracking_code' => $transaction->tracking_code,
            'items' => $items,
            'status' => $status,
            'time' => $this->delivery,
            'delivery_at' => $this->delivery_at == null ? 'هنوز تحویل داده نشده' : Controller::MiladyToShamsi2($this->delivery_at),
            'recv_name' => $this->recv_name,
            'recv_phone' => $this->recv_phone,
            'x' => $this->x,
            'y' => $this->y,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'city' => City::find($this->city_id)->first()->name,
            'recp_href' => route('api.get_recp', ['purchase' => $this->id])
        ];
    }
}
