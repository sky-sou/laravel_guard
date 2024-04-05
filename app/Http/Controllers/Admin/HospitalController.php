<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Services\HospitalService;

class HospitalController extends Controller
{
    private  $HospitalService;

    public function __construct()
    {
        $this->HospitalService = new HospitalService();
    }

    function index(Request $request){
        
        $data = [];
        $options = $this->setListDefault($request);
        $options['with'] = $this->setWithDefault();
        
        $results = $this->HospitalService->index($options, false);

        if($results->total() > 0){
            $data = $results->toArray()['data'];
        }

        $data = $this->setUpdaterInfo($data);
        return $this->view('hospital.index', ['data' => $data,
                                                'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];

        if($id == 'new')
            $result = $this->HospitalService->new();
        else
            $result = $this->HospitalService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('hospital.show', ['data' => $data]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];

        if($id == 'new')
            $result = $this->HospitalService->new();
        else
            $result = $this->HospitalService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('hospital.edit', ['data' => $data]);
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
            'address',
            'email',
            'tel',
            'fax',
            'status',
            'desc'
        ]);

        if(empty($save_data['status'])){
            $save_data['status'] = 0;
        }

        if(empty($save_data['name'])){
            session()->flash('error_message', __('名稱為空'));
            $error_flg = true;
        }

        //更新保存判斷
        if($id != 'new'){
            if(empty($this->HospitalService->find($id, [], false)))
                return response(__('無操作權限'), 403);
        }

        // 保存
        if(!$error_flg){
            if($id == 'new')
                $result = $this->HospitalService->store($save_data, $this->guard);
            else
                $result = $this->HospitalService->update($id , $save_data, $this->guard);

            if($result){
                session()->flash('message', __('保存完成'));
                // 導向詳細畫面
                return redirect()->route('adminHospital', ['hospital_id' => $result->id]);
            }
            else{
                session()->flash('error_message', __('保存失敗'));
                $error_flg = true;
            }
        }

        // 失敗重整欄位
        if($error_flg){
            if($is_new)
                $data = $this->HospitalService->new();
            else
                $data = $this->HospitalService->find($id, [], false);

            foreach($save_data as $name => $value){
                $data->{$name} = $value;
            }
        }

        return $this->view('hospital.edit', ['data' => $data]);
    }

    function updateStatus(Request $request, $id, $status){
        $result = $this->HospitalService->update($id , ['status' => (bool)$status], $this->guard);
        if($result){
            session()->flash('message', __('保存完成'));
        }
        else{
            session()->flash('error_message', __('保存失敗'));
        }
        return redirect()->back();

    }
}
