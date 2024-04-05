<?php

namespace App\Traits\Relationships;

use App\Models\User;
use App\Models\Admin;
use App\Models\HospitalAdmin;

trait HasDeleter
{
    // 刪除者
	public function DeletedUser()
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }

    // 刪除者
	public function DeletedAdmin()
    {
        return $this->hasOne(Admin::class, 'id', 'deleted_by');
    }

    // 刪除者
	public function DeletedHospitalAdmin()
    {
        return $this->hasOne(HospitalAdmin::class, 'id', 'deleted_by');
    }
}
