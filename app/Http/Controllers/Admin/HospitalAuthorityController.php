<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Helpers\AuthorityInfo;
use App\Services\HospitalService;

class HospitalAuthorityController extends Controller
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
        return $this->view('hospital_authority.index', ['data' => $data,
                                                        'listInfo' => $this->setListInfo($results)]);
    }

    function show(Request $request, $id){
        $data = [];
        $options = [];
        $authority = AuthorityInfo::getList('hospital');
        
        if($id == 'new')
            $result = $this->HospitalService->new();
        else
            $result = $this->HospitalService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('hospital_authority.show', ['data' => $data,
                                                            'authority' => $authority]);
        }
        else{
            return response(__('無操作權限'), 403);
        }
    }

    function edit(Request $request, $id){
        $data = [];
        $options = [];
        $authority = AuthorityInfo::getList('hospital');
        
        if($id == 'new')
            $result = $this->HospitalService->new();
        else
            $result = $this->HospitalService->find($id, $options, false);

        if($result){
            $data = $result;
            $data->permission = json_decode($data->permission);
            return $this->view('hospital_authority.edit', ['data' => $data,
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
        $authority = AuthorityInfo::getList('hospital');
        $save_data = $request->only([
            'authority',
            'desc'
        ]);
        $save_data['permission'] = json_encode($save_data['authority']);
        unset($update['authority']);

        // 保存
        if(!$error_flg){
            if($id == 'new')
                $result = $this->HospitalService->store($save_data, $this->guard);
            else
                $result = $this->HospitalService->update($id , $save_data, $this->guard);

             if($result){
                 session()->flash('message', __('保存完成'));
                 // 導向詳細畫面
                 return redirect()->route('hospital', ['hospital_id' => $result->id]);
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
                if($name == 'permission')
                    $data->permission = json_decode($value);
                else
                    $data->{$name} = $value;
            }
        }

        return $this->view('hospital_authority.edit', ['data' => $data,
                                                        'authority' => $authority]);
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
