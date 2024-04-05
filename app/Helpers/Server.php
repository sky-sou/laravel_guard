<?php

namespace App\Helpers;

class Server
{
	public static function getUserIP()
    {
        $ip_array = array();
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip_array['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CLIENT_IP'];
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip_array['HTTP_X_FORWARDED_FOR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        if(!empty($_SERVER['HTTP_X_FORWARDED']))
            $ip_array['HTTP_X_FORWARDED'] = $_SERVER['HTTP_X_FORWARDED'];
        if(!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ip_array['HTTP_X_CLUSTER_CLIENT_IP'] = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
            $ip_array['HTTP_FORWARDED_FOR'] = $_SERVER['HTTP_FORWARDED_FOR'];
        if(!empty($_SERVER['HTTP_FORWARDED']))
            $ip_array['HTTP_FORWARDED'] = $_SERVER['HTTP_FORWARDED'];
        if(!empty($_SERVER['REMOTE_ADDR']))
            $ip_array['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        if(!empty($_SERVER['HTTP_VIA']))
            $ip_array['HTTP_VIA'] = $_SERVER['HTTP_VIA'];

        $check_ip = '';
        foreach($ip_array as $key => $value){
            if(!empty($check_ip) && $check_ip != $value){
                return 0;
            }
            $check_ip = $value;
        }
        return $check_ip;
    }

    public static function getUserBrowser(){
        $browser = strtolower($_SERVER['HTTP_USER_AGENT']);
        // 以瀏覽器引擎判定
        if (strstr($browser , 'edge'))
            $browser = "Edge";
        else if (strstr($browser , 'trident') || strstr($browser , 'msie'))
            $browser = "Internet Explorer";
        else if (strstr($browser , 'chrome'))
            $browser = "Google Chrome";
        else if (strstr($browser , 'firefox'))
            $browser = "Firefox";
        else if (strstr($browser , 'safari'))
            $browser = "Safari";
        else if (strstr($browser , 'opera'))
            $browser = "Opera";
        else if (strstr($browser , 'postman'))
            $browser = "Postman";
        else
            $browser = $_SERVER['HTTP_USER_AGENT'];
        
        return $browser;
    }

    public static function getUserDevice(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if(preg_match("/iPod/", $user_agent))
            $device = 'iPod';
        else if(preg_match("/iPad/", $user_agent))
            $device = 'iPad';
        else if(preg_match("/iPhone/", $user_agent))
            $device = 'iPhone';
        else if(preg_match("/android/i", $user_agent))
            $device = 'android';
        else
            $device = 'PC';
        
        return $device;
    }
}
