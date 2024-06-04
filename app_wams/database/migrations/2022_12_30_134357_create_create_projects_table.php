<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_projects', function (Blueprint $table) {
            $table->id();
            $table->string('id_project');
            $table->string('project_name');
            $table->string('principal_name');
            $table->string('client_name');
            $table->string('file');
            $table->bigInteger('bmt');
            $table->bigInteger('services');
            $table->string('lain');
            $table->bigInteger('wapu');
            $table->bigInteger('subtotal');
            $table->bigInteger('bunga_admin');
            $table->bigInteger('biaya_admin');
            $table->bigInteger('biaya_pengurangan');
            $table->bigInteger('total_final');
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
        Schema::dropIfExists('create_projects');
    }
}
