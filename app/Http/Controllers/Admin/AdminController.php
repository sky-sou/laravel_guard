<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;

class AdminController extends Controller
{
    private  $AdminService;

    public function __construct()
    {
        $this->AdminService = new AdminService();
    }

    function index(Request $request){
        
        $data = [];
        $options = $this->setListDefault($request);
        $options['with'] = $this->setWithDefault();

        $results = $this->AdminService->index($options, false);

        if($results->total() > 0){
            $data = $results->toArray()['data'];
        }

        $data = $this->setUpdaterInfo($data);
        return $this->view('admin.index', ['data' => $data,
                                            'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];

        if($id == 'new')
            $result = $this->AdminService->new();
        else
            $result = $this->AdminService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('admin.show', ['data' => $data]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];

        if($id == 'new')
            $result = $this->AdminService->new();
        else
            $result = $this->AdminService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('admin.edit', ['data' => $data]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function save(Request $request, $id){
        $is_new = false;
        $result = false;
        $error_flg = false;
        $save_data = $request->only([
            'name',
            'account',
            'status',
            'email',
            'desc'
        ]);

        if(empty($save_data['status'])){
            $save_data['status'] = 0;
        }

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

        elseif(!$this->AdminService->checkAccountOverlapped($save_data['account'], $id)){
            session()->flash('error_message', __('帳號名稱重複'));
            $error_flg = true;
        }

        //更新保存判斷
        if($id != 'new'){
            if(empty($this->AdminService->find($id, [], false)))
                return response(__('無操作權限'), 403);
        }

        // 保存
        if(!$error_flg){
            if($id == 'new')
                $result = $this->AdminService->store($save_data, $this->guard);
            else
                $result = $this->AdminService->update($id , $save_data, $this->guard);

            if($result){
                session()->flash('message', __('保存完成'));
                // 導向詳細畫面
                return redirect()->route('admin', ['admin_id' => $result->id]);
            }
            else{
                session()->flash('error_message', __('保存失敗'));
                $error_flg = true;
            }
        }

        // 失敗重整欄位
        if($error_flg){
            if($is_new)
                $data = $this->AdminService->new();
            else
                $data = $this->AdminService->find($id, [], false);

            foreach($save_data as $name => $value){
                $data->{$name} = $value;
            }
        }

        return $this->view('admin.edit', ['data' => $data]);
    }

    function updateStatus(Request $request, $id, $status){
        $result = $this->AdminService->update($id , ['status' => (bool)$status], $this->guard);
        if($result){
            session()->flash('message', __('保存完成'));
        }
        else{
            session()->flash('error_message', __('保存失敗'));
        }
        return redirect()->back();

    }
}
