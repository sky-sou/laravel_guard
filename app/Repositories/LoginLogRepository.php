<?php
namespace App\Repositories;

use App\Constant\LoginLogConstant;
use App\Models\LoginLog;
use App\Helpers\Server;

class LoginLogRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
    }

    // 使用model
    public function model()
    {
        return new LoginLog();
    }

    // 關聯表單
    public function with($with)
    {
        $with_list = $this->defaultWith();
        $with_list['User'] = function ($query) {$query->select('id', 'name');};
        $with_list['Admin'] = function ($query) {$query->select('id', 'name');};
        $with_list['HospitalAdmin'] = function ($query) {$query->select('id', 'name');};

        return $with_list[$with];
    }

    // 一覽頁面
    public function index($options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();

        $model = $model->select('id', 
                                'user_id',
                                'type',
                                'ip',
                                'device',
                                'browser',
                                'logged_in_at');

        if(isset($options['search']) && !empty($options['search'])){            
            $this->model = $this->model->where(function ($query) use ($options) {
                $query = $query->orWhere('user_id', 'like', '%'.$options['search'].'%');
            });
        }

        return parent::index($options, $status, $model);
    }
    
    // 快速紀錄
    public function record($guard = null)
    {
        $this->model = $this->model();

        if(empty($guard)){
            $user = auth()->user();
        }
        else{
            $user = auth()->guard($guard)->user();
            $this->model->created_type = $guard;
            $this->model->updated_type = $guard;
        }

        $this->model->user_id      = $user->id;
        $this->model->type         = $user->type;
        $this->model->ip           = Server::getUserIP();
        $this->model->device       = Server::getUserDevice();
        $this->model->browser      = Server::getUserBrowser();
        $this->model->logged_in_at = date('Y-m-d H:i:s');
        $this->model->created_by   = $user->id;
        $this->model->updated_by   = $user->id;
        
        $this->model->save();
    }
}
