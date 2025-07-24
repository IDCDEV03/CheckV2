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
        Schema::create('public_records', function (Blueprint $table) {
            $table->id();          
            $table->string('form_id', 20); 
            $table->string('record_id', 20)->unique();
            $table->string('license_plate');     
            $table->string('car_type'); 
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
        Schema::dropIfExists('public_records');
    }
};
