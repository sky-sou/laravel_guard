<?php

namespace App\Helpers;

class AuthorityInfo
{
	public static function getList($group = null)
    {
        $auth = [
            'admin' => ['admin-authority',
                        'hospital-authority',
                        'user-authority'],
            'hospital' => ['dashboard',
                            'info',
                            'infos'],
            'user' => ['dashboard',
                        'info',
                        'infos'],
        ];

        if(!empty($group)){
            if(isset($auth[$group]))
                return $auth[$group];
            else
                return [];

        }

        return $auth;
    }
}
