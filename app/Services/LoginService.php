<?php

namespace App\Services;

use App\Repositories\LoginRepository;

class LoginService
{
    protected $repository;
    protected $AuthorityRepository;

    public function __construct()
    {
        $this->repository = new LoginRepository();
    }

    function login($guard = 'user', $account, $password, $remember_me = ''){

        return $this->repository->login($guard, $account, $password, $remember_me);
    }
    
    function logout($guard = 'user'){
        
        return $this->repository->logout($guard);
    }
}
