<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalis_bsm2s', function (Blueprint $table) {
            $table->id();
            $table->string('submitter_id');
            $table->string('tracking_id')->nullable();
            $table->date('ship_date')->nullable();
            $table->string('bsm2_id');
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
        Schema::dropIfExists('personalis_bsm2s');
    }
};
