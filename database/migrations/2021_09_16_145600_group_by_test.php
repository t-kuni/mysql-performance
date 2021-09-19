<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupByTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_by_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->integer('no');
            $table->timestamps();
        });

        // 単一インデックス
        Schema::create('single_index_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text')->index();
            $table->integer('no');
            $table->timestamps();
        });

        // 複合インデックス
        Schema::create('multi_index_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->integer('no');
            $table->timestamps();

            $table->index(["text", "no"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_by_records');
        Schema::dropIfExists('single_index_records');
        Schema::dropIfExists('multi_index_records');
    }
}
