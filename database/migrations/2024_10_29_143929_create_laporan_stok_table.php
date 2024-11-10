<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanStokTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_stok', function (Blueprint $table) {
            $table->string('kode_barang', 50)->primary();
            $table->string('nama_barang', 100);
            $table->integer('jumlah_tersedia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_stok');
    }
}

