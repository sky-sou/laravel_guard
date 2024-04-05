<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationships\HasCreator;
use App\Traits\Relationships\HasUpdater;
use App\Traits\Relationships\HasDeleter;

class AdminAuthority extends Model
{
    use SoftDeletes;
    use HasCreator;
    use HasUpdater;
    use HasDeleter;

    // table 設定
    protected $table = 'admin_authority';


    // 建立時預設欄位
    protected $attributes = [

    ];

    // 取得時，隱藏的欄位
    protected $hidden = [
    ];
    
}
