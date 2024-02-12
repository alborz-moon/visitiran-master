<?php

namespace App\Console\Commands;

use App\Mail\TestMail as MailTestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        Mail::to('mghaneh1375@yahoo.com')->send(new MailTestMail([
            'name' => "محمد قانع",
            "invoice_no" => "TB21321321",
            'event' => 'رویداد سمپل'
        ]));
    }
}
