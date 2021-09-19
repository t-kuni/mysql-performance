<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JoinFiveTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_1_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no');
            $table->string('name');
        });
        Schema::create('join_2_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("1_id");
            $table->unsignedBigInteger("3_id");
            $table->integer('no');
            $table->string('name');
        });
        Schema::create('join_3_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no');
            $table->string('name');
        });
        Schema::create('join_4_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("3_id");
            $table->unsignedBigInteger("5_id");
            $table->integer('no');
            $table->string('name');
        });
        Schema::create('join_5_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no');
            $table->string('name');
        });

        // 外部キー
//        Schema::table("join_2_records", function (Blueprint $table) {
//            $table->foreign('1_id')->references('id')->on('join_1_records');
//            $table->foreign('3_id')->references('id')->on('join_3_records');
//        });
//        Schema::table("join_4_records", function (Blueprint $table) {
//            $table->foreign('3_id')->references('id')->on('join_3_records');
//            $table->foreign('5_id')->references('id')->on('join_5_records');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("join_2_records", function (Blueprint $table) {
            $table->dropForeign('join_2_records_1_id_foreign');
            $table->dropForeign('join_2_records_3_id_foreign');
        });
        Schema::table("join_4_records", function (Blueprint $table) {
            $table->dropForeign('join_4_records_3_id_foreign');
            $table->dropForeign('join_4_records_5_id_foreign');
        });

        Schema::dropIfExists('join_1_records');
        Schema::dropIfExists('join_2_records');
        Schema::dropIfExists('join_3_records');
        Schema::dropIfExists('join_4_records');
        Schema::dropIfExists('join_5_records');
    }
}
