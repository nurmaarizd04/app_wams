<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_projets', function (Blueprint $table) {
            $table->id();
            $table->string("no_sales");
            $table->string("tgl_sales");
            $table->string("kode_project");
            $table->string("nama_sales");
            $table->string("nama_institusi");
            $table->string("nama_project");
            $table->string("nama_pm")->nullable();
            $table->string("hps");
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
        Schema::dropIfExists('list_projets');
    }
}
