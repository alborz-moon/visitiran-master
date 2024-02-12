<?php

namespace App\Listeners;

use App\Events\BuyEvent;
use App\Http\Controllers\Shop\BasketController;
use App\Mail\BuyShopMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class BuyEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BuyEvent $event)
    {
        if($event->mail != null) {

            $pdf = BasketController::doGenerateRecpPDF($event->user, $event->purchase);
            $filename_recp = storage_path('tmp/' . time() . '.pdf');
            $pdf->save($filename_recp);

            Mail::to($event->mail)->send(new BuyShopMail($event, $filename_recp));

        }
    }
}
