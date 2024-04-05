<?php

namespace App\Traits\Relationships;

use App\Models\User;
use App\Models\Admin;
use App\Models\HospitalAdmin;

trait HasUpdater
{
    // 更新者
	public function UpdatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    // 更新者
	public function UpdatedAdmin()
    {
        return $this->hasOne(Admin::class, 'id', 'updated_by');
    }

    // 更新者
	public function UpdatedHospitalAdmin()
    {
        return $this->hasOne(HospitalAdmin::class, 'id', 'updated_by');
    }
}
