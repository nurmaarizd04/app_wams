<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionsMakerInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_maker_internal', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal')->nullable();
            $table->string('jenis_transaksi')->nullable();
            $table->string('nama_tujuan')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('upload_request')->nullable();
            $table->string('upload_release')->nullable();
            $table->string('id_project_internal');
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
        Schema::dropIfExists('transactions_maker_internal');
    }
}
