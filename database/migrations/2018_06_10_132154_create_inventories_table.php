<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->smallIncrements('id')->primary();
            $table->unsignedInteger('number')->nullable();
            $table->unsignedSmallInteger('type_id')->nullable();
            $table->unsignedSmallInteger('classroom_id')->nullable();
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
