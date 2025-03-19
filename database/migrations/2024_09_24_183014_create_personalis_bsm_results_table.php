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
        Schema::create('personalis_bsm_results', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['letter','commentor','shipped_by']);
            $table->bigInteger('count');
            $table->string('ship_date');
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
        Schema::dropIfExists('personalis_bsm_results');
    }
};
