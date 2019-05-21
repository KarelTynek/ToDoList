<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id_project')->primary();
            $table->string('title', 32);
            $table->text('description');
            $table->integer('fk_type')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('fk_type')->references('id_type')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
