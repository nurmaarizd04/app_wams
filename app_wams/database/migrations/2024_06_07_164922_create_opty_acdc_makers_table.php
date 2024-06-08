<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptyAcdcMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opty_acdc_makers', function (Blueprint $table) {
            $table->id();
            $table->integer('opty_acdc_id');
            $table->dateTime('date_trx');
            $table->string('jenis_trx');
            $table->string('nama_penerima');
            $table->bigInteger('nominal_trx');
            $table->string('keterangan');
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
        Schema::dropIfExists('opty_acdc_makers');
    }
}
