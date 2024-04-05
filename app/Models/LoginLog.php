<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationships\HasCreator;
use App\Traits\Relationships\HasUpdater;
use App\Traits\Relationships\HasDeleter;

class LoginLog extends Model
{
    use SoftDeletes;
    use HasCreator;
    use HasUpdater;
    use HasDeleter;

    // table 設定
    protected $table = 'login_log';


    // 建立時預設欄位
    protected $attributes = [

    ];

    // 取得時，隱藏的欄位
    protected $hidden = [
    ];

    // 使用者
    public function User(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // 使用者
    public function Admin(){
        return $this->hasOne(Admin::class, 'id', 'user_id');
    }

    // 使用者
    public function HospitalAdmin(){
        return $this->hasOne(HospitalAdmin::class, 'id', 'user_id');
    }
}