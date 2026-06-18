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
            $table->unsignedBigInteger('id_satuan')->nullable()->after('harga');
            $table->foreign('id_satuan')->references('id')->on('msatuan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_laundry', function (Blueprint $table) {
            $table->dropForeign(['id_satuan']);
            $table->dropColumn('id_satuan');
        });
    }
};
