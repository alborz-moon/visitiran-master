<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms {phone}';

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
        
        $phone = $this->argument('phone');

        $username = 'tourism';
        $password = 'RWgEwZfVJRivoKdO';
        $domain = 'magfa';

        // url
        $url = 'https://sms.magfa.com/api/soap/sms/v2/server?wsdl';
        // soap options
        $options = [
            'login' => "$username/$domain",'password' => $password, // -Credientials
            'cache_wsdl' => WSDL_CACHE_NONE, // -No WSDL Cache
            'compression' => (SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | 5), // -Compression *
            'trace' => false // -Optional (debug)
        ];
        // * Accept response compression and compress requests using gzip with compression level 5

        // soap client
        $client = new \SoapClient( $url, $options);
        $result = $client->send(
            ["تست ارسال پيامک. Sample Text for test."], // messages
            ["30009629"], // short numbers can be 1 or same count as recipients (mobiles)
            [$phone], // recipients
            [], // client-side unique IDs.
            [], // Encodings are optional, The system will guess it, itself ;)
            [], // UDHs, Please read Magfa UDH Documnet
            [] // Message priorities (unused).
        );

        var_dump($result);
    }
}
