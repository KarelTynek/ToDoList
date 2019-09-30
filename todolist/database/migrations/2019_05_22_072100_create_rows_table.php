<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rows', function (Blueprint $table) {
            $table->increments('id_row');
            $table->text('description');
            $table->integer('fk_column')->unsigned()->index();
            $table->smallInteger('priority')->default(2);
            $table->timestamps();
        });

        Schema::table('rows', function (Blueprint $table) {
            $table->foreign('fk_column')->references('id_column')->on('columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rows');
    }
}
