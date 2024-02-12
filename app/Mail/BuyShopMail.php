<?php

namespace App\Mail;

use App\Events\BuyEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BuyShopMail extends Mailable
{
    use Queueable, SerializesModels;

    public $buyEvent;
    public $filename_recp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BuyEvent $buyEvent, $filename_recp)
    {
        $this->buyEvent = $buyEvent;
        $this->filename_recp = $filename_recp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->subject('جزییات سفارش')
                ->view('emails.buy_shop', [
                    'name' => $this->buyEvent->user->first_name != null ? 
                        $this->buyEvent->user->first_name . ' ' . $this->buyEvent->user->last_name :
                        'کاربر',
                    "invoice_no" => $this->buyEvent->purchase->transaction->tracking_code
                ])->attach($this->filename_recp, [
                    'as' => 'recp.pdf',
                    'mime' => 'application/pdf',
           ]);
    }
}
