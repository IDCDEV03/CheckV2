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
        Schema::table('public_records', function (Blueprint $table) {
            $table->unsignedBigInteger('user_data_id')->nullable()->after('car_type');
            $table->index('user_data_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('public_records', function (Blueprint $table) {
            //
        });
    }
};
