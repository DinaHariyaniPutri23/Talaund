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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            // Foreign Keys (menggunakan konvensi _id agar relasi model lebih otomatis)
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('user_id'); // Kasir
            $table->unsignedBigInteger('promo_id')->nullable();
            $table->unsignedBigInteger('pengiriman_id');

            // Data Transaksi
            $table->datetime('tanggal_transaksi');
            $table->integer('total_transaksi')->default(0);
            
            $table->timestamps();

            // Referensi (agar constraint DB aman, opsional tapi disarankan)
            // Akan kita biarkan lepas dulu (tanpa constraint foreign key ketat) 
            // karena Laravel Eloquent bisa mengelolanya di level aplikasi.
            // Tapi jika ingin ketat:
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('promo_id')->references('id')->on('promo')->onDelete('set null');
            $table->foreign('pengiriman_id')->references('id')->on('jenis_pengiriman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
