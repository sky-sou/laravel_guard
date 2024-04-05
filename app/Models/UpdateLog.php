<?php

namespace App\Models;

use App\Traits\SignatureColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relationships\HasCreator;
use App\Models\User;

/*
    'id'          => '',
    'name'        => '',
    'type'        => '',
    'zone'        => '',
    'count'       => '人數',
    'create_by'   => '',
    'create_time' => '',
    'update_by'   => '',
    'update_time' => '',
    'status'      => ''
*/

class UpdateLog extends Model
{
    use HasCreator;
	
    //無法批量給值的欄位，類似黑名單
    protected $guarded = [];

    protected $table = 'update_log';

    // 時間欄位名稱(與下面timestamp欄位擇一使用)
    // 更改laravel預設的時間欄位名稱

    // 不使用laravel預設的timestamp欄位
    // 因為此表單沒有 update_time 欄位 所以直接取消
    public $timestamps = false;

    // 建立時預設欄位
    protected $attributes = [
        'class_id'   => 0,
        'created_by' => 0
    ];

    // 建立者
	public function Creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
