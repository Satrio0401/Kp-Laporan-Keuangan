<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('no_faktur', 50)->primary();
            $table->date('tanggal_pembelian');
            $table->string('kode_supplier', 50);
            $table->string('nama_barang', 100);
            $table->decimal('harga_satuan', 10, 2);
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            $table->foreign('kode_supplier')->references('kode_supplier')->on('supplier');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

