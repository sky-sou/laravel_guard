<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationships\HasCreator;
use App\Traits\Relationships\HasUpdater;
use App\Traits\Relationships\HasDeleter;

class Admin extends Authenticatable
{
    use SoftDeletes;
    use HasCreator;
    use HasUpdater;
    use HasDeleter;

    // table 設定
    protected $table = 'admin';


    // 建立時預設欄位
    protected $attributes = [

    ];
    
    // 可變更欄位
    protected $fillable = [
        'status',
    ];

    // 不可變更欄位
    protected $guarded = [
    ];

    // 取得時，隱藏的欄位
    protected $hidden = [
        'password',
        'remember_token'
    ];

}
