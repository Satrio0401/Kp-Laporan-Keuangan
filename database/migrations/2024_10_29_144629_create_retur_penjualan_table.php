<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPenjualanTable extends Migration
{
    public function up()
    {
        Schema::create('retur_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_retur');
            $table->string('no_faktur', 50);
            $table->foreignId('id_menu')->constrained('menu');
            $table->integer('jumlah_dikembalikan');
            $table->text('alasan')->nullable();
            $table->enum('status', ['diterima', 'pending', 'ditolak']);
            $table->timestamps();

            $table->foreign('no_faktur')->references('no_faktur')->on('transaksi_penjualan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('retur_penjualan');
    }
}
