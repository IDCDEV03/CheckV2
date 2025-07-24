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
        Schema::create('public_record_results', function (Blueprint $table) {
            $table->id();
            $table->string('record_id', 20);
            $table->string('item_id');
            $table->string('result_value',200); // 1 = pass, 0 = fail
            $table->text('user_comment')->nullable();
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
        Schema::dropIfExists('public_record_results');
    }
};
