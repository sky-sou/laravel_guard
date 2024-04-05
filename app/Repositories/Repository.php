<?php
namespace App\Repositories;

use App\Models\UpdateLog;

abstract class Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    abstract protected function model();
    abstract protected function with($with);

    // 新資料預設
    public function new()
    {
        return $this->model();
    }

    // 關聯表單
    public function defaultWith()
    {
        $with_list = ['CreatedUser'          => function ($query) {$query->select('id', 'name');},
                      'CreatedAdmin'         => function ($query) {$query->select('id', 'name');}, 
                      'CreatedHospitalAdmin' => function ($query) {$query->select('id', 'name');}, 
                      'UpdatedUser'          => function ($query) {$query->select('id', 'name');}, 
                      'UpdatedAdmin'         => function ($query) {$query->select('id', 'name');}, 
                      'UpdatedHospitalAdmin' => function ($query) {$query->select('id', 'name');}, 
                      'DeletedUser'          => function ($query) {$query->select('id', 'name');}, 
                      'DeletedAdmin'         => function ($query) {$query->select('id', 'name');}, 
                      'DeletedHospitalAdmin' => function ($query) {$query->select('id', 'name');},];

        return $with_list;
    }
    
    // 一覽
    public function index($options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();
        
        // 關聯
        if (array_key_exists('with', $options)) {
            if(!is_array($options['with']))
                $options['with'] = [$options['with']];
    
            foreach($options['with'] as $with){
                $model = $model->with([$with => $this->with($with)]);
            }
        }

        // 排序
        if (array_key_exists('orderBy', $options)) {
            $model = $model->orderBy($options['orderBy']['field'], $options['orderBy']['direction']);
        }
        else{
            $model = $model->orderby('id', 'DESC');
        }

        // 狀態
        if($status)
            $model = $model->where('status', '=', 1);
        
        if(isset($options['pagination']))
            return $model->paginate($options['pagination']);
        
        return $model->get();

    }

    // 詳細
    public function find($id, $options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();
                      
        // 關聯
        if (array_key_exists('with', $options)) {
            if(!is_array($options['with']))
                $options['with'] = [$options['with']];
    
            foreach($options['with'] as $with){
                $model = $model->with([$with => $this->with($with)]);
            }
        }

        if($status)
            $model = $model->where('status', '=', 1);

        $model = $model->where('id', '=', $id);
            
        return $model->first();
    }
    
    // 新增
    public function store($data = [], $guard = null, $model = null)
    {
        if(empty($model))
            $model = $this->new();

        foreach($data as $key => $value){
            $model->{$key} = $value;
        }

        foreach($data as $key => $value){
            $model->{$key} = $value;
        }

        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');

        if(!empty($guard)){
            $user_id = auth()->guard($guard)->user()->id;
            $model->created_type = $guard;
            $model->updated_type = $guard;
        }
        else{
            $user_id = auth()->user()->id;
        }

        $model->created_by = $user_id;
        $model->updated_by = $user_id;
        
        if($model->save())
            return $model;
        else
            return false;
    }

    // 更新
    public function update($id, $data = [], $guard = null, $model = null)
    {
        if(empty($model))
            $model = $this->new()->find($id);

        if(empty($model))
            return false;

        foreach($data as $key => $value){
            $model->{$key} = $value;
        }

        if(!empty($guard)){
            $user_id = auth()->guard($guard)->user()->id;
            $model->updated_type = $guard;
        }
        else{
            $user_id = auth()->user()->id;
        }

        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = $user_id;

        if($model->save())
            return $model;
        else
            return false;
    }
    
    // 更新
    public function newLog($model, $model_id, $action)
    {
        $log = new UpdateLog();
        
        $log->class = get_class($model);
        $log->class_id = $model_id;
        $log->action = $action;

        if(!empty($guard)){
            $user_id = auth()->guard($guard)->user()->id;
            $log->created_type = $guard;
        }
        else{
            $user_id = auth()->user()->id;
        }

        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = $user_id;

        if($action != 'index' && $action != 'find')
            $log->old = json_encode($model);
        
        return $log->save();
    }
}
