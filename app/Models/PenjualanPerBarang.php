<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPerBarang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'penjualan_per_barang'; // Ganti dengan nama tabel Anda

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id'; // Ganti jika Anda menggunakan kolom lain

    // Menentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'no_faktur', // Kolom yang menyimpan no_faktur
        'id_menu', // Jika Anda menggunakan relasi dengan tabel menu
        'jumlah', // Jumlah penjualan barang
        'harga', // Harga per item
        'subtotal', // Total subtotal
        'created_at', // Waktu pembuatan
        'updated_at' // Waktu pembaruan
    ];

    // Definisikan relasi dengan model TransaksiPenjualan
    public function transaksiPenjualan()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'no_faktur', 'no_faktur');
    }

    // Definisikan relasi dengan model Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id'); // Ganti 'menu_id' dan 'id' sesuai kolom Anda
    }
}

