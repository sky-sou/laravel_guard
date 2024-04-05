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
        Schema::create('user_authority', function (Blueprint $table) {
            $table->increments('id')->comment('使用者權限ID');
            $table->string('name')->comment('名稱');
            $table->json('permission')->comment('權限');
            $table->text('desc')->nullable()->comment('備註');
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
        Schema::dropIfExists('authority');
    }
};
