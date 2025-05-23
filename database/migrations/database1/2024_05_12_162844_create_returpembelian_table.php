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
        Schema::create('returpembelians', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_faktur');
            $table->date('tanggal_pengembalian');
            $table->string('kode_pembelian');
            $table->string('nama_pemasok');
            $table->decimal('total_faktur', 10, 2);
            $table->decimal('pembayaran_berbayar', 10, 2);
            $table->decimal('jumlah_karena', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returpembelians');
    }
};
