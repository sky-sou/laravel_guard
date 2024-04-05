<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthorityInfo;
use App\Services\UserAuthorityService;

class UserAuthorityController extends Controller
{
    private  $UserAuthorityService;

    public function __construct()
    {
        $this->UserAuthorityService = new UserAuthorityService();
    }

    function index(Request $request){
        $data = [];
        $options = $this->setListDefault($request);
        $options['with'] = $this->setWithDefault();

        $results = $this->UserAuthorityService->index($options, false);

        if($results->total() > 0){
            $data = $results->toArray()['data'];
        }

        $data = $this->setUpdaterInfo($data);
        return $this->view('user_authority.index', ['data' => $data,
                                                        'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];
        $authority = AuthorityInfo::getList('user');
        
        if($id == 'new')
            $result = $this->UserAuthorityService->new();
        else
            $result = $this->UserAuthorityService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);

            return $this->view('user_authority.show', ['data' => $data,
                                                       'authority' => $authority]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];
        $authority = AuthorityInfo::getList('user');
        
        if($id == 'new')
            $result = $this->UserAuthorityService->new();
        else
            $result = $this->UserAuthorityService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);

            return $this->view('user_authority.edit', ['data' => $data,
                                                       'authority' => $authority]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function update(Request $request, $id){
        $is_new = false;
        $result = false;
        $error_flg = false;
        $authority = AuthorityInfo::getList('user');
        $save_data = $request->only([
            'name',
            'status',
            'authority',
            'desc'
        ]);
        $save_data['permission'] = json_encode($save_data['authority']);
        unset($save_data['authority']);

        if(empty($save_data['name'])){
            session()->flash('error_message', __('名稱為空'));
            $error_flg = true;
        }
        
        // 保存
        if(!$error_flg){
            if($id == 'new')
                $result = $this->UserAuthorityService->store($save_data, $this->guard);
            else
                $result = $this->UserAuthorityService->update($id , $save_data, $this->guard);

            if($result){
                session()->flash('message', __('保存完成'));
                // 導向詳細畫面
                return redirect()->route('user', ['user_id' => $result->id]);
            }
            else{
                session()->flash('error_message', __('保存失敗'));
                $error_flg = true;
            }
        }

        // 失敗重整欄位
        if($error_flg){
            if($is_new)
                $data = $this->UserAuthorityService->new();
            else
                $data = $this->UserAuthorityService->find($id, [], false);

            foreach($save_data as $name => $value){
                if($name == 'permission')
                    $data->permission = json_decode($value);
                else
                    $data->{$name} = $value;
            }
        }

        return $this->view('user_authority.edit', ['data' => $data,
                                                    'authority' => $authority]);
    }

    function updateStatus(Request $request, $id, $status){
        $result = $this->UserAuthorityService->update($id , ['status' => (bool)$status], $this->guard);
        if($result){
            session()->flash('message', __('保存完成'));
        }
        else{
            session()->flash('error_message', __('保存失敗'));
        }
        return redirect()->back();

    }
}