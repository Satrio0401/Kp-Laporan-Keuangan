<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPemesanan extends Model
{
    use HasFactory;

    protected $table = 'retur_pemesanan'; // Nama tabel yang sesuai
    protected $fillable = [
        'tanggal_retur',
        'no_faktur',
        'id_menu',
        'jumlah_dikembalikan',
        'alasan',
        'total_harga',
        'status'
    ];

     // Definisikan relasi ke model TransaksiPenjualan
     public function transaksiPenjualan()
     {
         return $this->belongsTo(TransaksiPenjualan::class, 'no_faktur', 'no_faktur');
     }
 
     // Definisikan relasi ke model Menu jika diperlukan
     public function menu()
     {
         return $this->belongsTo(Menu::class, 'id_menu', 'id');
     }
 }
