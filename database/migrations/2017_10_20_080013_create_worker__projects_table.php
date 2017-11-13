<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_worker', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('project_id')->unsigned();
            $table->integer('worker_id')->unsigned();

            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')
                ->on('workers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_worker');
    }
}
