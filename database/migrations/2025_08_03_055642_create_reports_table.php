<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_id')->unique(); // Perbaiki ini
            $table->foreignId('depo_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_laporan');
            $table->enum('kategori', [
                'overload', 
                'kerusakan_sensor', 
                'sampah_berserakan', 
                'bau_tidak_sedap', 
                'lainnya'
            ]);
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])
                   ->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index('report_id');
            $table->index('status');
            $table->index('kategori');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}