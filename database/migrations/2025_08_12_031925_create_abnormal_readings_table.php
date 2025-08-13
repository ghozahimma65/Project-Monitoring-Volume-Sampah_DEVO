<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('abnormal_readings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('depo_id')->constrained()->onDelete('cascade');
        $table->string('nilai_terbaca'); // Nilai aneh yang dikirim sensor
        $table->text('catatan'); // Alasan kenapa dianggap aneh
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('abnormal_readings');
    }
};
