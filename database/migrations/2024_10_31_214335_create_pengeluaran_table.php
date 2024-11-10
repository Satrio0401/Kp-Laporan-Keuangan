<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->string('kode_biaya')->primary(); // Kode biaya sebagai primary key
            $table->date('tanggal_pengeluaran'); // Tanggal pengeluaran
            $table->string('biaya_untuk'); // Biaya untuk
            $table->decimal('total_pengeluaran', 10, 2); // Total pengeluaran
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
        Schema::dropIfExists('pengeluaran');
    }
}
