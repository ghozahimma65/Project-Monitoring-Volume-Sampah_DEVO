<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorReadingsTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('depo_id')->constrained()->onDelete('cascade');
            $table->string('esp_id'); // ID ESP32
            $table->decimal('volume', 8, 4); // kontribusi volume sensor ini
            $table->timestamp('reading_time');
            $table->timestamps();
            
            $table->index(['depo_id', 'reading_time']);
            $table->index(['esp_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_readings');
    }
}

// $history = SensorReading::where('deposit_id', $id)
//             ->orderBy('created_at', 'desc')
//             ->take(50) // ambil 50 data terbaru
//             ->get();
