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
        Schema::create('personalis_bsms', function (Blueprint $table) {
            $table->id();
            $table->string('submitter_id');
            $table->string('letter')->nullable();
            $table->string('commentor')->nullable();
            $table->string('shipped_by')->nullable();
            $table->string('ship_date')->nullable();
            $table->foreignId('bsm_id')->constrained('personlis_bsm_sheets');
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
        Schema::dropIfExists('personalis_bsms');
    }
};
