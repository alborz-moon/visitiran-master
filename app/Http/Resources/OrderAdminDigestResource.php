<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAdminDigestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transaction = $this->transaction;

        $status = 'در حال ارسال';
        if($this->status == Purchase::$FINALIZED)
            $status = 'مرجوعی';
        else if($this->status == Purchase::$DELIVERED)
            $status = 'تحویل شده';

        $user = User::find($transaction->user_id);

        return [
            'id' => $this->id,
            'created_at' => Controller::MiladyToShamsi3($this->created_at->timestamp),
            'total' => number_format($transaction->amount),
            'off_amount' => number_format($transaction->off_amount),
            'tracking_code' => $transaction->tracking_code,
            'transaction_code' => $transaction->transaction_code,
            'items_count' => $this->purchase_items->count(),
            'status' => $status,
            'time' => $this->delivery,
            'delivery_at' => $this->delivery_at == null ? 'هنوز تحویل داده نشده' : Controller::MiladyToShamsi2($this->delivery_at),
            'user' => [
                'name' => $user->first_name != null && $user->last_name != null ? $user->first_name . ' ' . $user->last_name : '',
                'phone' => $user->phone
            ]
        ];
    }
}
