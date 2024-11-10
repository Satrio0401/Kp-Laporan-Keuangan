<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'pengeluaran';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'kode_biaya',
        'tanggal_pengeluaran',
        'biaya_untuk',
        'total_pengeluaran',
    ];

    // Menentukan primary key
    protected $primaryKey = 'kode_biaya';

    // Menentukan apakah primary key adalah string
    protected $keyType = 'string';

    // Menentukan apakah kolom timestamps diaktifkan
    public $timestamps = true;
}
