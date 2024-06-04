<?php

namespace App\Service;

class Functions
{
    public function __construct()
    {
        
    }

    public static function ErrorMessage($http_code, $details = ''){
        return array(
            'error' => array(
                'code'      =>  (int)       $http_code,
                'message'   =>  (string)    null, // isset($config->http_code->$http_code) ? $config->http_code->$http_code : "",
                'details'   =>  (string)    $details == ''               ? "" : $details,
            )
        );
    }
}
