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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('layanan_id')->nullable();
            $table->unsignedBigInteger('pencucian_id')->nullable();

            // Data Kalkulasi
            $table->integer('harga_unit')->default(0); // Harga dasar (entah dari pencucian per kg atau satuan item)
            $table->integer('total_berat')->default(1); // Qty / Berat
            $table->integer('subtotal')->default(0); // harga_unit * total_berat * multiplier (jika ada)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
