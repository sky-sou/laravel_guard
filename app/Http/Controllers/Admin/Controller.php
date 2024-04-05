<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected $guard = 'admin';
    
    function view($path, $data = []){

        return view('admin.'.env('ADMIN_THEME_FOLDER', 'default').'.'.$path, $data);
    }
    
    function setListDefault($request){

        $options = ['search' => '',
                    'pagination' => 10];

        if(!empty((int)$request->get('pagination'))){
            $options['pagination'] = (int)$request->get('pagination');
        }

        if(!empty($request->get('search'))){
            $options['search'] = trim($request->get('search'));
        }

        return $options;
    }
    
    function setWithDefault(){

        return ['CreatedUser','CreatedAdmin','CreatedHospitalAdmin',
                'UpdatedUser','UpdatedAdmin','UpdatedHospitalAdmin',
                'DeletedUser','DeletedAdmin','DeletedHospitalAdmin',];
    }
    
    function setListInfo($data){

        return ['currentPage' => $data->currentPage(),
                'nextPageUrl' => $data->nextPageUrl(),
                'lastPage' => $data->lastPage(),
                'perPage' => $data->perPage(),
                'total' => $data->total()];
    }
    
    function setUpdaterInfo($data){
        foreach($data as $row => $value){
            if($value['created_type'] == 'admin'){
                $data[$row]['created_user'] = $value['created_admin'];

            }
            elseif($value['created_type'] == 'hospital'){
                $data[$row]['created_user'] = $value['created_hospital_admin'];
            }
            unset($data[$row]['created_admin']);
            unset($data[$row]['created_hospital_admin']);

            if($value['updated_type'] == 'admin'){
                $data[$row]['updated_user'] = $value['updated_admin'];

            }
            elseif($value['updated_type'] == 'hospital'){
                $data[$row]['updated_user'] = $value['updated_hospital_admin'];
            }
            unset($data[$row]['updated_admin']);
            unset($data[$row]['updated_hospital_admin']);

            if($value['deleted_type'] == 'admin'){
                $data[$row]['deleted_user'] = $value['deleted_admin'];
            }
            elseif($value['deleted_type'] == 'hospital'){
                $data[$row]['deleted_user'] = $value['deleted_hospital_admin'];
            }
            unset($data[$row]['deleted_admin']);
            unset($data[$row]['deleted_hospital_admin']);
        }

        return $data;
    }
}
