<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthorityInfo;
use App\Services\AdminService;

class AdminAuthorityController extends Controller
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
        return $this->view('admin_authority.index', ['data' => $data,
                                                    'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];
        $authority = AuthorityInfo::getList('admin');
        
        if($id == 'new')
            $result = $this->AdminService->new();
        else
            $result = $this->AdminService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('admin_authority.show', ['data' => $data,
                                                        'authority' => $authority]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];

        $authority = AuthorityInfo::getList('admin');
        
        if($id == 'new')
            $result = $this->AdminService->new();
        else
            $result = $this->AdminService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('admin_authority.edit', ['data' => $data,
                                                        'authority' => $authority]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function save(Request $request, $id){
        $is_new = false;
        $result = false;
        $error_flg = false;
        $authority = AuthorityInfo::getList('admin');
        $save_data = $request->only([
            'authority',
            'desc'
        ]);
        $save_data['permission'] = json_encode($save_data['authority']);
        unset($save_data['authority']);

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

        return $this->view('admin_authority.edit', ['data' => $data,
                                                    'authority' => $authority]);
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
