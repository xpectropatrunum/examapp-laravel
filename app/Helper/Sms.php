<?php

namespace App\Helper;

class Sms
{
    static function send($phone, $code)
    {
        return true;
   
        if (
            file_get_contents("http://ippanel.com:8080/?apikey=HUaVcXS0hSlwm_FPVpcyeCw1pKJexKlW8I_JYDuQPg0=&pid=9nexzrpoo5x14fa&fnum=5000125475&tnum={$phone}&p1=code&v1={$code}")
         > 0
        ) {
            return true;
        }
        return false;
    }

}
