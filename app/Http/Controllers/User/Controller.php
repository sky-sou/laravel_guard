<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected $guard = 'user';
    function view($path, $data = []){

        return view('user.'.env('USER_THEME_FOLDER', 'default').'.'.$path, $data);
    }
}
