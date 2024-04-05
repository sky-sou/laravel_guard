<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_admin', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('管理者ID');
            $table->bigInteger('hospital_id')->comment('醫院ID');
            $table->string('account')->unique()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->string('name')->comment('名稱');
            $table->string('email')->comment('Email');
            $table->bigInteger('hospital_admin_authority_id')->default('0')->unsigned()->comment('醫院管理權限ID');
            $table->string('remember_token', 128)->nullable()->comment('記住我Token');
            $table->text('desc')->nullable()->comment('說明');
            $table->tinyInteger('status')->unsigned()->default('1')->comment('狀態');
            $table->string('deleted_type', 32)->default('user')->comment('刪除者類別');
            $table->bigInteger('deleted_by')->unsigned()->default('0')->comment('刪除者');
            $table->timestamp('deleted_at')->nullable()->comment('刪除時間');
            $table->string('created_type', 32)->default('user')->comment('建立者類別');
            $table->bigInteger('created_by')->unsigned()->default('0')->comment('建立者');
            $table->timestamp('created_at')->comment('建立時間')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->string('updated_type', 32)->default('user')->comment('更新者類別');
            $table->bigInteger('updated_by')->unsigned()->default('0')->comment('更新者');
            $table->timestamp('updated_at')->comment('更新時間')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
