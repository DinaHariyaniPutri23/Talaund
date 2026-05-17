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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->string('id_xendit')->nullable(); // ID dari payment gateway
            $table->datetime('tanggal_bayar')->nullable();
            $table->string('metode_bayar')->nullable(); // Cash, Transfer, QRIS, dll
            $table->string('status_bayar')->default('unpaid'); // unpaid, paid, failed, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
