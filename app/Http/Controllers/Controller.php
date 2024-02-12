<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    //   public static $EVENT_SITE = 'bogenstudio.at';
    //  public static $SHOP_SITE = 'shop.bogenstudio.com';
    
  public static $EVENT_SITE = 'myevent.com';
  public static $SHOP_SITE = 'myshop.com';

    // public static $EVENT_SITE = 'events.visitiran.ir';
    // public static $SHOP_SITE = 'hcshop.taci.ir';
    
    public static function hasAnyExcept($expected, $real) {

        foreach ($real as $itr) {
            if($itr !== '_token' && !in_array($itr, $expected)) {
                // dd($itr);
                return true;
            }
        }
        return false;
    }

    public static function _custom_check_national_code($code) {

        if(!preg_match('/^[0-9]{10}$/',$code))
            return false;

        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$code))
                return false;
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($code, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($code, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }
    
    public static function getPersianDate($date){

        include_once 'jdate.php';
        $e = '';
        $e .= jdate('d', '', $date->timestamp) . ' ';
        $e .= jdate('F', '', $date->timestamp) . ' ';
        $e .= jdate('Y', '', $date->timestamp);
        return $e;
    }

    public static function MiladyToShamsi3($ts){
        include_once 'jdate.php';
        return jdate('l d F سال Y - H:m', "", $ts);
    }

    public static function MiladyToShamsi2($ts){
        include_once 'jdate.php';
        return jdate('l d F سال Y', "", $ts);
    }
    
    public static function MiladyToIntShamsi($date, $explode='-'){
        include_once 'jdate.php';
        $date = explode(' ', $date);
        $d = explode($explode, $date[0]);
        $splited = explode('/', gregorian_to_jalali($d[0],$d[1],$d[2],'/'));
        $str = $splited[0];

        if(strlen($splited[1]) == 1)
            $str .= '0' . $splited[1];
        else
            $str .= $splited[1];
            
        if(strlen($splited[2]) == 1)
            $str .= '0' . $splited[2];
        else
            $str .= $splited[2];

        return (int)str_replace('/', '', $str);
    }

    public static function MiladyToShamsi($date, $explode='-'){
        include_once 'jdate.php';
        $date = explode(' ', $date);
        $d = explode($explode, $date[0]);
        return gregorian_to_jalali($d[0],$d[1],$d[2],'/');
    }
    
    public static function ShamsiToMilady($date, $delimeter='/'){
        include_once 'jdate.php';
        $date = explode($delimeter, $date);
        return jalali_to_gregorian($date[0],$date[1],$date[2], '-');
    }
    
    public static function convertDateToString($date) {
        $subStrD = explode('/', $date);
        return $subStrD[0] . $subStrD[1] . $subStrD[2];
    }
    
    public static function convertStringToDate($date) {
        return $date[0] . $date[1] . $date[2] . $date[3] . '/' . $date[4] . $date[5] . '/' . $date[6] . $date[7];
    }

    public static function getToday() {

        include_once 'jdate.php';

        $jalali_date = jdate("c");

        $date_time = explode('-', $jalali_date);

        $subStr = explode('/', $date_time[0]);

        $day = $subStr[0] . $subStr[1] . $subStr[2];

        $time = explode(':', $date_time[1]);

        $time = $time[0] . $time[1];

        return ["date" => $day, "time" => $time];
    }

    public static function sendSMS($phone, $text) {

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
            [$text], // messages
            ["30009629"], // short numbers can be 1 or same count as recipients (mobiles)
            [$phone], // recipients
            [], // client-side unique IDs.
            [], // Encodings are optional, The system will guess it, itself ;)
            [], // UDHs, Please read Magfa UDH Documnet
            [] // Message priorities (unused).
        );
    }

    protected static $COMMON_ERRS = [
        'postal_code.required' => 'لطفا کدپستی موردنظر را وارد نمایید',
        'nid.required' => 'لطفا کدملی موردنظر را وارد نمایید',
        'postal_code.regex' => 'کد پستی موردنظر نامعتبر است',
        'phone.required' => 'شماره همراه موردنظر را وارد نمایید',
        'phone.regex' => 'شماره همراه وارد شده نامعتبر است',
        'phone.exists' => 'شماره همراه وارد شده در سامانه موجود نمی باشد',
        'user_NID.regex' => 'کدملی وارد شده نامعتبر است',
        'launcher_type.in' => 'نوع شخصیت اشتباه است',
        'launcher_phone.*.*' => 'تلفن وارد شده نامعتبر است',
        'launcher_city_id.exists' => 'شهر وارد شده نامعتبر است',
        'city_id.exists' => 'شهر وارد شده نامعتبر است',
        'launcher_x.regex' => 'مختصات وارد شده نامعتبر است',
        'launcher_y.regex' => 'مختصات وارد شده نامعتبر است',
        'x.regex' => 'مختصات وارد شده نامعتبر است',
        'y.regex' => 'مختصات وارد شده نامعتبر است',
        'nid.regex' => 'کدملی وارد شده نامعتبر است',
        '*.email' => 'ایمیل وارد شده نامعتبر است',
        'label.required' => 'لطفا عنوان را وارد نمایید',
        'title.required' => 'لطفا عنوان را وارد نمایید',
        'header.required' => 'لطفا عنوان را وارد نمایید',
        'digest.required' => 'لطفا متن خلاصه را وارد نمایید',
        'priority.required' => 'لطفا اولویت را وارد نمایید',
        'img_file.required' => 'لطفا تصویر موردنظر خود را بارگذاری نمایید',
        '*.url' => 'لینک وارد شده معتبر نمی باشد',
        'code.required' => 'لطفا کد را وارد نمایید',
    ];

}
