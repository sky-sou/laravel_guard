<?php

namespace App\Services;

use App\Repositories\UserAuthorityRepository;

class UserAuthorityService extends Service
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
    }

    // 使用Repository
    public function repository()
    {
        return new UserAuthorityRepository();
    }

    // 一覽頁面
    public function index($options = [], $status = true, $model = null)
    {
        return parent::index($options, $status, $model);
    }

    // 詳細頁面
    public function find($id, $options = [], $status = true, $model = null)
    {
        return parent::find($id, $options, $status, $model);
    }

    // 新增
    public function store($data = [], $guard = null, $model = null)
    {
        return parent::store($data, $guard, $model);
    }

    // 更新
    public function update($id, $data = [], $guard = null, $model = null)
    {
        return parent::update($id, $data, $guard, $model);
    }
}
