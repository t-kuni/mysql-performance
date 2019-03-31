<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('type_kind_2');
            $table->integer('type_kind_10');
            $table->integer('seq');
            $table->integer('type_kind_2_index')->index();
            $table->integer('type_kind_10_index')->index();
            $table->integer('seq_index')->index();
            $table->timestamps();
        });
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('type_kind_2');
            $table->integer('type_kind_10');
            $table->integer('seq');
            $table->integer('type_kind_2_index')->index();
            $table->integer('type_kind_10_index')->index();
            $table->integer('seq_index')->index();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('password_resets');
    }
}
