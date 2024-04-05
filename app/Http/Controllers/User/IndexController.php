<?php

namespace App\Http\Controllers\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\User\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constant\UserConstant;


class IndexController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private  $LoginService;

    public function __construct()
    {
        $this->LoginService = new LoginService();
        
    }

    function login(Request $request){
        // 指定取得參數
        $data = $request->only([
            'account',
            'password',
            'remember_me',
        ]);
        
        if(Auth::guard('user')->check()){
            return redirect()->route('userDashboard');
        }

        if(!empty($data['account']) && !empty($data['password'])){
            if(!isset($data['remember_me']))
                $data['remember_me'] = 0;

            if($this->LoginService->login($this->guard, $data['account'], $data['password'], $data['remember_me'])){
                return redirect()->route('userDashboard');
            }

            session()->flash('error_message', __('登入失敗'));
        }

        return $this->view('index.login', []);
    }

    function logout(Request $request){

        if($this->LoginService->logout($this->guard)){
            session()->flash('message', __('登出成功'));
        }
        else{
            session()->flash('error_message', __('登出失敗'));
        }

        return redirect()->route('userRoot');
    }
}
