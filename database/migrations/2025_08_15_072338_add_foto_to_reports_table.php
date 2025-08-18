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
    Schema::table('reports', function (Blueprint $table) {
        // Menambahkan kolom baru untuk menyimpan NAMA FILE foto
        // `nullable()` berarti kolom ini boleh kosong jika tidak ada foto
        $table->string('foto')->nullable()->after('deskripsi');
    });
}

public function down()
{
    Schema::table('reports', function (Blueprint $table) {
        // Perintah untuk menghapus kolom jika migrasi di-rollback
        $table->dropColumn('foto');
    });
}
};
