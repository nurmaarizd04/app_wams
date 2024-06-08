<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptyAcdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opty_acdcs', function (Blueprint $table) {
            $table->id();
            $table->string('code_opty');
            $table->integer('mdc_id');
            $table->string('project_name');
            $table->string('account_manager');
            $table->bigInteger('nominal');
            $table->string('no_penawaran');
            $table->boolean('is_moved')->default(false);
            $table->string('file');
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
        Schema::dropIfExists('opty_acdcs');
    }
}
