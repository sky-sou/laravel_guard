<?php

namespace App\Services;


abstract class Service
{
    protected $repository;

    public function __construct()
    {
        $this->repository = $this->repository();
    }

    abstract protected function repository();
    
    // 新資料預設
    public function new()
    {
        return $this->repository->model();
    }

    // 一覽頁面
    public function index($options = [], $status = true, $model = null)
    {
        return $this->repository->index($options, $status, $model);
    }

    // 詳細頁面
    public function find($id, $options = [], $status = true, $model = null)
    {
        return $this->repository->find($id, $options, $status, $model);
    }

    // 新增
    public function store($data = [], $guard = null, $model = null)
    {
        return $this->repository->store($data, $guard, $model);
    }

    // 更新
    public function update($id, $data = [], $guard = null, $model = null)
    {
        return $this->repository->update($id, $data, $guard, $model);
    }
}
