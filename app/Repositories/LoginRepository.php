<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Constant\UserConstant;
use App\Models\Admin;
use App\Models\User;
use App\Models\HospitalAdmin;
use App\Repositories\LoginLogRepository;

class LoginRepository
{
    protected $model;

    public function __construct()
    {
    }

    function login($guard = 'user', $account, $password, $remember_me = ''){

        $LoginLogRepository = new LoginLogRepository();

        if($guard == 'user')
            $user = new User();
        elseif($guard == 'admin')
            $user = new Admin();
        elseif($guard == 'hospital')
            $user = new HospitalAdmin();
        else
            return false;

        $user = $user->where('account', $account)
                ->where('status', UserConstant::STATUS_ACTIVE)->first();

        if(!empty($user)){
            if(Hash::check($password, $user->password)){
                Auth::guard($guard)->login($user, (bool)$remember_me);
                auth()->guard($guard)->user()->type = $guard;
                $LoginLogRepository->record($guard);

                return true;
            }
        }
        return false;
    }
    
    function logout($guard = 'user'){

        Auth::guard('user')->logout();
        Auth::guard('hospital')->logout();
        Auth::guard('admin')->logout();

        if($guard == 'user')
            return redirect()->route('userRoot');
        elseif($guard == 'admin')
            return redirect()->route('adminRoot');
        elseif($guard == 'hospital')
            return redirect()->route('hospitalRoot');

        return redirect()->route('userRoot');
    }
}
