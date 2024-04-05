<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
    }
    function index(Request $request){
        
        return $this->view('dashboard.index', ['articles' => []]);
    }
}
