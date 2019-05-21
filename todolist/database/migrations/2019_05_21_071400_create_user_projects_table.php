<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_projects', function (Blueprint $table) {
            $table->increments('id_up');
            $table->uuid('fk_user')->index();
            $table->uuid('fk_project')->index();
        });

        Schema::table('user_projects', function (Blueprint $table) {
            $table->foreign('fk_user')->references('id')->on('users');
            $table->foreign('fk_project')->references('id_project')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_projects');
    }
}
