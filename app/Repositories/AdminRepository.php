<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Constant\AdminConstant;
use App\Models\Admin;

class AdminRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
    }

    // 使用model
    public function model()
    {
        return new Admin();
    }

    // 關聯表單
    public function with($with)
    {
        $with_list = $this->defaultWith();

        return $with_list[$with];
    }

    // 一覽頁面
    public function index($options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();

        $model = $model->select('id', 
                                'name', 
                                'desc',
                                'status',
                                'created_at',
                                'created_type',
                                'created_by',
                                'updated_at',
                                'updated_type',
                                'updated_by',
                                'deleted_at',
                                'deleted_type',
                                'deleted_by');
                                           
        if(isset($options['search']) && !empty($options['search'])){            
            $model = $model->where(function ($query) use ($options) {
                $query = $query->orWhere('name', 'like', '%'.$options['search'].'%');
            });
        }

        return parent::index($options, $status, $model);
    }

    // 詳細頁面
    public function find($id, $options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();
        
        $model = $model->select('id', 
                                'name',
                                'account',
                                'email',
                                'permission',
                                'desc',
                                'status',
                                'created_at',
                                'created_type',
                                'created_by',
                                'updated_at',
                                'updated_type',
                                'updated_by',
                                'deleted_at',
                                'deleted_type',
                                'deleted_by');

        return parent::find($id, $options, $status, $model);
    }
    
    // 新增
    public function store($data = [], $guard = null, $model = null)
    {
        $data['password'] = Hash::make($data['password']);

        return parent::store($data, $guard, $model);
    }

    // 更新
    public function update($id, $data = [], $guard = null, $model = null)
    {
        return parent::update($id, $data, $guard, $model);
    }

    // 檢查帳號重複
    public function checkAccountOverlapped($account, $id = null)
    {
        $model = $this->new();
        $model = $model->select('id', 'account')
                        ->where('account', '=', $account);
        if(!empty($id))
            $model = $model->where('id', '!=', $id);
        
        $result = $model->first();
        if(empty($result))
            return true;

        return false;
    }
}
