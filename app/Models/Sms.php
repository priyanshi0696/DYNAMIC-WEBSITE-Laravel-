<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;
    public static function sendSms($message,$mobile){
        $request ="";
        $param['authorization']="UyfZYCEInMBe91H0Sr5VLcwONljbxsJWq7vg8uX6oDikht3pKmVnaitb4s8hwf1P0QLTlIJZyepEGRgA";
        $param['sender_id'] = 'FastSM';
        $param['message']=$message;
        $param['numbers']= $mobile;
        $param['language']="english";
        $param['route']="p";

        foreach($param as $key=>$val) {
            $request.= $key."=".urlencode($val);
            $request.= "&";
        }
        $request = substr($request, 0, strlen($request)-1);

        $url ="https://www.fast2sms.com/dev/bulk?".$request;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
    }
}