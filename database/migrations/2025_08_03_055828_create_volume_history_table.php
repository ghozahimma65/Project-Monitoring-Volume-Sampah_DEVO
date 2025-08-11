<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumeHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('volume_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('depo_id')->constrained()->onDelete('cascade');
            $table->decimal('volume', 10, 2);
            $table->decimal('persentase', 5, 2);
            $table->enum('status', ['normal', 'warning', 'critical']);
            $table->timestamp('recorded_at');
            
            $table->index(['depo_id', 'recorded_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('volume_history');
    }
}