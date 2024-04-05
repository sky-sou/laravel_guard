<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Constant\UserConstant;
use App\Models\User;

class UserRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
    }

    // 使用model
    public function model()
    {
        return new User();
    }

    // 關聯表單
    public function with($with)
    {
        $with_list = $this->defaultWith();
        $with_list['UserAuthority'] = function ($query) {$query->select('id', 'name');};

        return $with_list[$with];
    }

    // 一覽頁面
    public function index($options = [], $status = true, $model = null)
    {
        if(empty($model))
            $model = $this->new();
        
        $model = $model->select('id', 
                                'account', 
                                'name', 
                                'email', 
                                'user_authority_id', 
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

        // 查詢
        if(isset($options['search']) && !empty($options['search'])){            
            $model = $model->where(function ($query) use ($options) {
                $query = $query->orWhere('account', 'like', '%'.$options['search'].'%');
                $query = $query->orWhere('name', 'like', '%'.$options['search'].'%');
                $query = $query->orWhere('email', 'like', '%'.$options['search'].'%');
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
                                'account', 
                                'name', 
                                'email', 
                                'user_authority_id', 
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

    // 更新
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
