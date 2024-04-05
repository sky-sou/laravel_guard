<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Hospital\Controller;
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
