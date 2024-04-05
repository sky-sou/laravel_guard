<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
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
