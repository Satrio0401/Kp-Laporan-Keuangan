<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanPerBarangTable extends Migration
{
    public function up()
    {
        Schema::create('penjualan_per_barang', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur', 50);
            $table->foreignId('id_menu')->constrained('menu');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('no_faktur')->references('no_faktur')->on('transaksi_penjualan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan_per_barang');
    }
}

