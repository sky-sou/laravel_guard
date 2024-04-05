<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('update_log', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('class', 128)->nullable()->comment('class');
            $table->bigInteger('class_id')->unsigned()->default('0')->comment('class ID');
            $table->string('action', 32)->nullable()->comment('動作');
            $table->json('old')->nullable()->comment('修改前');
            $table->string('created_type', 32)->default('user')->comment('建立者類別');
            $table->bigInteger('created_by')->unsigned()->default('0')->comment('建立者');
            $table->timestamp('created_at')->comment('建立時間')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        /*
        CREATE TABLE `ssp_update_log` (
            `id` bigint(20) NOT NULL COMMENT 'ID',
            `class` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'class',
            `class_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'class ID',
            `action` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '動作',
            `old` json DEFAULT NULL COMMENT '修改前',
            `created_by` bigint(20) NOT NULL DEFAULT '0' COMMENT '建立者',
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ALTER TABLE `ssp_update_log` ADD PRIMARY KEY (`id`);
        ALTER TABLE `ssp_update_log` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID';
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_log');
    }
};
