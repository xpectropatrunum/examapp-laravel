<?php
namespace App\Helpers;

class Sms
{
    static function notifyAdmin($phone, $name, $type, $url )
    {
        $name = urlencode($name);
        $type = urlencode($type);
        if(file_get_contents("http://ippanel.com:8080/?apikey=HUaVcXS0hSlwm_FPVpcyeCw1pKJexKlW8I_JYDuQPg0=&pid=3kq5fq0toy2qus6&fnum=5000125475&tnum={$phone}&p1=name&v1={$name}&p2=type&v2={$type}&p3=url&v3={$url}") > 0){
            return 1;
        }
        return 0;

    }
    static function notifyStudent($phone, $name)
    {
        $name = urlencode($name);
        if(file_get_contents("http://ippanel.com:8080/?apikey=HUaVcXS0hSlwm_FPVpcyeCw1pKJexKlW8I_JYDuQPg0=&pid=e9557392mri7oo3&fnum=5000125475&tnum={$phone}&p1=name&v1={$name}") > 0){
            return 1;
        }
        return 0;

    }
   
}
