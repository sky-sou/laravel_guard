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
        Schema::create('login_log', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('序列ID');
            $table->bigInteger('user_id')->comment('使用者ID');
            $table->string('type', 32)->comment('使用類型');
            $table->string('ip')->comment('登入IP');
            $table->string('device')->comment('裝置');
            $table->string('browser')->comment('瀏覽器');
            $table->timestamp('logged_in_at')->comment('登入時間');
            $table->tinyInteger('status')->unsigned()->default('1');
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
        Schema::dropIfExists('login_log');
    }
};
