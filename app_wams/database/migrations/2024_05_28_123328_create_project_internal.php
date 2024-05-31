<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_internal', function (Blueprint $table) {
            $table->id();
            $table->string('id_project')->nullable();
            $table->string('nama_project')->nullable();
            $table->string('nama_client')->nullable();
            $table->string('pic')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('file')->nullable();
            $table->string('realisasi')->nullable()->default(null);
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
        Schema::dropIfExists('project_internal');
    }
}
