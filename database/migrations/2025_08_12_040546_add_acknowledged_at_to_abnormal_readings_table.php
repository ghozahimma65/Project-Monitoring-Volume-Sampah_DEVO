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
    Schema::table('abnormal_readings', function (Blueprint $table) {
        // Kolom untuk mencatat waktu konfirmasi
        $table->timestamp('acknowledged_at')->nullable()->after('catatan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('abnormal_readings', function (Blueprint $table) {
        $table->dropColumn('acknowledged_at');
    });
}
};
