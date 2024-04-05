<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected $guard = 'hospital';
    function view($path, $data = []){

        return view('hospital.'.env('HOSPITAL_THEME_FOLDER', 'default').'.'.$path, $data);
    }
}
