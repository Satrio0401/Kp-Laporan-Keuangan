<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangEDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangED', function (Blueprint $table) {
            $table->string('kode_barang')->primary(); // Kode barang sebagai primary key
            $table->string('lot'); // Lot
            $table->string('nama_barang'); // Nama barang
            $table->date('tanggal_masuk'); // Tanggal masuk
            $table->date('tanggal_kadaluarsa'); // Tanggal kadaluarsa
            $table->integer('jumlah_barang'); // Jumlah barang
            $table->timestamps(); // Menyimpan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangED');
    }
}
