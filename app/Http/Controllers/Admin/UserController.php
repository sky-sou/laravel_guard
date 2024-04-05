<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\UserAuthorityService;

class UserController extends Controller
{
    private  $UserService;
    private  $UserAuthorityService;

    public function __construct()
    {
        $this->UserService = new UserService();
        $this->UserAuthorityService = new UserAuthorityService();
    }

    function index(Request $request){

        $data = [];
        $options = $this->setListDefault($request);
        $options['with'] = $this->setWithDefault();
        $options['with'][] = 'UserAuthority';

        $results = $this->UserService->index($options, false);

        if($results->total() > 0){
            $data = $results->toArray()['data'];
        }

        $data = $this->setUpdaterInfo($data);
        return $this->view('user.index', ['data' => $data,
                                          'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];
        $user_authorities = $this->UserAuthorityService->index();
        $options['with'] = ['UserAuthority'];
        
        if($id == 'new')
            $result = $this->UserService->new();
        else
            $result = $this->UserService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);

            return $this->view('user.show', ['data' => $data,
                                             'user_authorities' => $user_authorities]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];
        $options['with'] = ['UserAuthority'];
        $user_authorities = $this->UserAuthorityService->index();
        
        if($id == 'new')
            $result = $this->UserService->new();
        else
            $result = $this->UserService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);

            return $this->view('user.edit', ['data' => $data,
                                             'user_authorities' => $user_authorities]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function save(Request $request, $id){
        $is_new = false;
        $result = false;
        $error_flg = false;
        $user_authorities = $this->UserAuthorityService->index();
        $save_data = $request->only([
            'name',
            'account',
            'password',
            'user_authority_id',
            'status',
            'email',
            'desc'
        ]);

        if(empty($save_data['status'])){
            $save_data['status'] = 0;
        }

        // 驗證
        if(empty($save_data['name'])){
            session()->flash('error_message', __('名稱為空'));
            $error_flg = true;
        }
        elseif(empty($save_data['account'])){
            session()->flash('error_message', __('帳號為空'));
            $error_flg = true;
        }
        elseif(empty($save_data['email'])){
            session()->flash('error_message', __('email為空'));
            $error_flg = true;
        }
        elseif(!$this->UserService->checkAccountOverlapped($save_data['account'], $id)){
            session()->flash('error_message', __('帳號名稱重複'));
            $error_flg = true;
        }

        //更新保存判斷
        if($id != 'new'){
            if(empty($this->UserService->find($id, [], false)))
                return response(__('無操作權限'), 403);
        }

        // 保存
        if(!$error_flg){
            if($id == 'new')
                $result = $this->UserService->store($save_data, $this->guard);
            else
                $result = $this->UserService->update($id , $save_data, $this->guard);

            if($result){
                session()->flash('message', __('保存完成'));
                // 導向詳細畫面
                return redirect()->route('adminUser', ['user_id' => $result->id]);
            }
            else{
                session()->flash('error_message', __('保存失敗'));
                $error_flg = true;
            }
        }

        // 失敗重整欄位
        if($error_flg){
            if($is_new)
                $data = $this->UserService->new();
            else
                $data = $this->UserService->find($id, [], false);
            
            foreach($save_data as $name => $value){
                $data->{$name} = $value;
            }
        }
        
        return $this->view('user.edit', ['data' => $data,
                                         'user_authorities' => $user_authorities]);
    }

    function updateStatus(Request $request, $id, $status){
        $result = $this->UserService->update($id , ['status' => (bool)$status], $this->guard);
        if($result){
            session()->flash('message', __('保存完成'));
        }
        else{
            session()->flash('error_message', __('保存失敗'));
        }
        return redirect()->back();

    }
}
