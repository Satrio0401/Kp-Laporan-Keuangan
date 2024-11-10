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
        Schema::create('BarangEDs', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->integer('jumlah_lot');
            $table->date('tanggal_kadaluarsa');
            $table->integer('persediaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BarangEDs');
    }
};
