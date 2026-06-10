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
        Schema::table('item_laundry', function (Blueprint $table) {
            $table->unsignedBigInteger('id_layanan')->nullable();
            $table->unsignedBigInteger('id_pencucian')->nullable();
            
            $table->foreign('id_layanan')->references('id')->on('layanan')->onDelete('set null');
            $table->foreign('id_pencucian')->references('id')->on('pencucian')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_laundry', function (Blueprint $table) {
            $table->dropForeign(['id_layanan']);
            $table->dropForeign(['id_pencucian']);
            $table->dropColumn('id_layanan');
            $table->dropColumn('id_pencucian');
        });
    }
};
