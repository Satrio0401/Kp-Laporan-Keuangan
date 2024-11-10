<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStok extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'laporan_stok';

    // Primary key
    protected $primaryKey = 'kode_barang';

    // Menentukan apakah primary key adalah incrementing
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jumlah_tersedia',
    ];

    // Menentukan apakah timestamps diaktifkan
    public $timestamps = true;
}
