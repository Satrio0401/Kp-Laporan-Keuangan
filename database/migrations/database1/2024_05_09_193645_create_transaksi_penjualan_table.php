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
        Schema::create('transaksipenjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur')->unique();
            $table->date('tanggal_penjualan');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('nama_pelanggan');
            $table->decimal('total_faktur', 15, 2);
            $table->decimal('pembayaran_berbayar', 15, 2);
            $table->decimal('jumlah_karena', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksipenjualans');
    }
};
