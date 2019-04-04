<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('type_kind_2_index')->index();
            $table->integer('type_kind_3');
            $table->integer('type_kind_3_index')->index();
            $table->integer('type_kind_4');
            $table->integer('type_kind_4_index')->index();
            $table->integer('type_kind_10');
            $table->integer('type_kind_10_index')->index();
            $table->integer('seq');
            $table->integer('seq_index')->index();
            $table->integer('rand');
            $table->integer('rand_index')->index();
            $table->integer('rand_nullable')->nullable();
            $table->integer('rand_nullable_index')->nullable()->index();
            $table->timestamps();

            $table->index(['type_kind_3_index', 'type_kind_4_index']);
        });
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('type_kind_2');
            $table->integer('type_kind_2_index')->index();
            $table->integer('type_kind_3');
            $table->integer('type_kind_3_index')->index();
            $table->integer('type_kind_4');
            $table->integer('type_kind_4_index')->index();
            $table->integer('type_kind_10');
            $table->integer('type_kind_10_index')->index();
            $table->integer('seq');
            $table->integer('seq_index')->index();
            $table->integer('nullable_a')->nullable();
            $table->integer('nullable_b')->nullable();
            $table->integer('nullable_c')->nullable();
            $table->integer('nullable_a_index')->nullable()->index();
            $table->integer('nullable_b_index')->nullable()->index();
            $table->integer('nullable_c_index')->nullable()->index();
            $table->integer('rand');
            $table->integer('rand_index')->index();
            $table->integer('rand_nullable')->nullable();
            $table->integer('rand_nullable_index')->nullable()->index();
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
