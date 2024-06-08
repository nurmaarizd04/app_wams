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
            $table->string('id_project')->unique();
            $table->integer('opty_acdc_id');
            $table->integer('client_id')->nullable();
            $table->integer('principal_id')->nullable();
            $table->string('file')->nullable();
            $table->string('type_wapu')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('bmt')->nullable();
            $table->bigInteger('services')->nullable();
            $table->string('lain')->nullable();
            $table->bigInteger('wapu')->nullable();
            $table->bigInteger('subtotal')->nullable();
            $table->bigInteger('bunga_admin')->nullable();
            $table->bigInteger('biaya_admin')->nullable();
            $table->bigInteger('biaya_pengurangan')->nullable();
            $table->bigInteger('total_final')->nullable();
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
