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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('status_transaksi', ['pending', 'diproses', 'selesai'])->default('pending')->after('total_transaksi');
            $table->text('alasan_void')->nullable()->after('status_transaksi');
            $table->timestamp('void_at')->nullable()->after('alasan_void');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['status_transaksi', 'alasan_void', 'void_at']);
        });
    }
};
