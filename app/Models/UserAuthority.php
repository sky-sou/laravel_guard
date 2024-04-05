<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationships\HasCreator;
use App\Traits\Relationships\HasUpdater;
use App\Traits\Relationships\HasDeleter;

class UserAuthority extends Model
{
    use SoftDeletes;
    use HasCreator;
    use HasUpdater;
    use HasDeleter;

    // table 設定
    protected $table = 'user_authority';


    // 建立時預設欄位
    protected $attributes = [
        'status' => '1'
    ];

    // 取得時，隱藏的欄位
    protected $hidden = [
    ];

    // 使用者
    public function User(){
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
