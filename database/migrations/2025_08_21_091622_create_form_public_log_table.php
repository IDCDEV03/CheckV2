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
        Schema::create('form_public_log', function (Blueprint $table) {
            $table->id();
            $table->string('form_id');
            $table->string('form_icon');
            $table->string('main_color');
            $table->string('bg_color');
            $table->string('show_status',20)->default('0');
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
        Schema::dropIfExists('form_public_log');
    }
};
