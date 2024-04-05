<?php

namespace App\Traits\Relationships;

use App\Models\User;
use App\Models\Admin;
use App\Models\HospitalAdmin;

trait HasCreator
{
    // 建立者
	public function CreatedUser()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    // 建立者
	public function CreatedAdmin()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by');
    }

    // 建立者
	public function CreatedHospitalAdmin()
    {
        return $this->hasOne(HospitalAdmin::class, 'id', 'created_by');
    }
}
