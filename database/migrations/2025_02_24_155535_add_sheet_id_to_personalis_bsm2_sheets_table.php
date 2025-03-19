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
        Schema::table('personalis_bsm2_sheets', function (Blueprint $table) {
            $table->string('sheet_id')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personalis_bsm2_sheets', function (Blueprint $table) {
            $table->removeColumn('sheet_id');
        });
    }
};
