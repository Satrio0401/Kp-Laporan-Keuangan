<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPembelianTable extends Migration
{
    public function up()
    {
        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->string('no_faktur', 50);
            $table->date('tanggal_retur');
            $table->string('kode_supplier', 50);
            $table->string('nama_barang', 100);
            $table->integer('jumlah_dikembalikan');
            $table->text('alasan')->nullable();
            $table->enum('status', ['diterima', 'pending', 'ditolak']);
            $table->timestamps();

            $table->foreign('no_faktur')->references('no_faktur')->on('pembelian');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('supplier');
        });
    }

    public function down()
    {
        Schema::dropIfExists('retur_pembelian');
    }
}

