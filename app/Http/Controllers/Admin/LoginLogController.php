<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Services\LoginLogService;

class LoginLogController extends Controller
{
    private  $LoginLogService;

    public function __construct()
    {
        $this->LoginLogService = new LoginLogService();
    }


    function index(Request $request){
        $data = [];
        $options = $this->setListDefault($request);
        $options['with'] = $this->setWithDefault();
        $options['with'][] = 'User';
        $options['with'][] = 'Admin';
        $options['with'][] = 'HospitalAdmin';

        $results = $this->LoginLogService->index($options, false);
        if($results->total() > 0){
            $data = $results->toArray()['data'];
        }
        
        return $this->view('log.login_log', ['data' => $data,
                                            'listInfo' => $this->setListInfo($results)]);
    }
}
