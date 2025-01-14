<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->boolean('aktif')->default(true); // Menambahkan kolom aktif dengan default true  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->dropColumn('aktif'); // Menghapus kolom aktif jika migrasi dibatalkan 
        });
    }
};
