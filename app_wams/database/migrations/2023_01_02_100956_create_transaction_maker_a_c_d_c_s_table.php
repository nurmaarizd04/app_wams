<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionMakerACDCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_maker_a_c_d_c_s', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis_transaksi')->nullable();
            $table->string('nama_tujuan');
            $table->bigInteger('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('upload_request')->nullable();
            $table->string('upload_release')->nullable();
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
        Schema::dropIfExists('transaction_maker_a_c_d_c_s');
    }
}
