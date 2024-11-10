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
        Schema::create('penjualanperbarangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur');
            $table->date('tanggal_penjualan');
            $table->string('nama_pelanggan');
            $table->string('nama_barang');
            $table->integer('jumlah_penjualan_barang');
            $table->decimal('jumlah_penjualan', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualanperbarangs');
    }
};
