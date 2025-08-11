<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeposTable extends Migration
{
    public function up()
    {
        Schema::create('depos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depo');
            $table->text('lokasi');
            $table->decimal('panjang', 8, 2); // meter
            $table->decimal('lebar', 8, 2); // meter
            $table->decimal('tinggi', 8, 2); // meter
            $table->integer('jumlah_sensor');
            $table->integer('jumlah_esp');
            $table->decimal('volume_maksimal', 10, 2); // m³
            $table->decimal('volume_saat_ini', 10, 2)->default(0);
            $table->decimal('persentase_volume', 5, 2)->default(0); // %
            $table->enum('status', ['normal', 'warning', 'critical'])->default('normal');
            $table->boolean('led_status')->default(false);
            $table->timestamp('last_updated')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depos');
    }
}