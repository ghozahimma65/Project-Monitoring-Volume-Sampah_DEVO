<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // critical_volume, new_report, etc
            $table->json('data'); // data notifikasi
            $table->timestamp('created_at');
            $table->boolean('is_read')->default(false);
            $table->string('target_audience')->default('admin'); // admin, public
            
            $table->index(['type', 'created_at']);
            $table->index(['is_read', 'target_audience']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
