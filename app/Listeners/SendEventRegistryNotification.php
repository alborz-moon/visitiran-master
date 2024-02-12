<?php

namespace App\Listeners;

use App\Events\EventRegistry;
use App\Http\Controllers\Event\EventBuyerController;
use App\Mail\EventRegistryMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


class SendEventRegistryNotification implements ShouldQueue
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
     * @param  \App\Events\EventRegistry  $event
     * @return void
     */
    public function handle(EventRegistry $event)
    {

        if($event->mail != null) {

            $pdf = EventBuyerController::doGenerateTicketPDF($event->event);
            $filename = storage_path('tmp/' . time() . '.pdf');
            $pdf->save($filename);

            $pdf = EventBuyerController::doGenerateRecpPDF($event->mail, $event->event->id, $event->event->title);
            $filename_recp = storage_path('tmp/recp_' . time() . '.pdf');
            $pdf->save($filename_recp);

            Mail::to('mghaneh1375@yahoo.com')->send(new EventRegistryMail($event, $filename, $filename_recp));

        }
        // Controller::sendSMS($event->phone, $event->eventName);
    }
}
