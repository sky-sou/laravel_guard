<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthorityInfo;
use App\Models\Admin;
use App\Models\Hospital;
use App\Models\HospitalAdminAuthority;
use App\Models\UserAuthority;
use App\Constant\AdminConstant;
use App\Constant\HospitalConstant;
use App\Constant\HospitalAdminAuthorityConstant;
use App\Constant\UserAuthorityConstant;

class CheckAuth
{
    public function handle($request, Closure $next, $role = null)
    {
        $auth = [];
        list($group, $action) = explode('|', $role);

        // 驗證時可通過的權限
        $check = ['all'      => ['all', 'store', 'readonly'],
                  'store'    => ['store', 'readonly'],
                  'update'   => ['update', 'readonly'],
                  'readonly' => ['readonly'],];

        // 解析網址（群組, 行為）
        if(!Auth::guard($group)->check() || empty(auth()->guard($group)->user())){
            if($group == 'admin')
                return redirect()->route('adminRoot');
            else if($group == 'hospital')
                return redirect()->route('hospitalRoot');
            else
                return redirect()->route('userRoot');
        }

        // 管理者權限
        if($group == 'admin'){
            $authority_id = auth()->guard($group)->user()->admin_authority_id;
            if(auth()->guard($group)->user()->id == 1){
                // 預設第一人，固定最大權限。
                $tmp = AuthorityInfo::getList('admin');
                foreach($tmp as $value){
                    $auth[$value] = 'all';
                }

            }
            else{
                $permission = Admin::select('permission')
                                            ->where('id', $authority_id)
                                            ->where('status', AdminConstant::STATUS_ACTIVE)
                                            ->first();
                if(!empty($permission)){
                    $auth = json_decode($permission->permission, true);
                }
            }
        }
        elseif($group == 'hospital'){
            $default = [];
            $hospital_id = auth()->guard($group)->user()->hospital_id;
            $authority_id = auth()->guard($group)->user()->hospital_admin_authority_id;
            $permission = Hospital::select('permission')
                                    ->where('hospital_id', $hospital_id)
                                    ->where('status', HospitalConstant::STATUS_ACTIVE)
                                    ->first();
            if(!empty($permission)){
                $default = json_decode($permission->permission, true);
            }
            $permission = HospitalAdminAuthority::select('permission')
                                            ->where('id', $authority_id)
                                            ->where('status', HospitalAdminAuthorityConstant::STATUS_ACTIVE)
                                            ->first();
            if(!empty($permission)){
                $auth = json_decode($permission->permission, true);
                foreach($auth as $auth_name => $value){
                    // 子權限存在於於主權限
                    if(!isset($default[$auth_name]))
                        unset($auth[$auth_name]);
                    else{
                        // 子權限不能大於主權限
                        if(!in_array($auth[$auth_name], $check[$default[$auth_name]]))
                            $auth[$auth_name] = $default[$auth_name];
                    }
                }
            }
                            
        }
        elseif($group == 'user'){
            $authority_id = auth()->guard($group)->user()->user_authority_id;
            $permission = UserAuthority::select('permission')
                                    ->where('id', $authority_id)
                                    ->where('status', UserAuthorityConstant::STATUS_ACTIVE)
                                    ->first();
            
            if(!empty($permission)){
                $auth = json_decode($permission->permission, true);
            }
        }

        auth()->guard($group)->user()->type = $group;
        if(!empty($auth)){
            auth()->guard($group)->user()->auth = $auth;
            if(isset($auth[$action]) || $action == 'none')
                return $next($request);
        }

        Auth::guard($group)->logout();

        if($group == 'admin')
            return redirect()->route('adminRoot');
        else if($group == 'hospital')
            return redirect()->route('hospitalRoot');
        else
            return redirect()->route('userRoot');

    }

}
