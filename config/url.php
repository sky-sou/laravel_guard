<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'root' => env('APP_URL', 'http://localhost'),
    'user_root' => env('APP_URL', 'http://localhost'),
    'hospital_root' => env('APP_URL', 'http://localhost').'/hospital',
    'admin_root' => env('APP_URL', 'http://localhost').'/'.env('APP_ADMIN_PATH', 'admin'),
];
