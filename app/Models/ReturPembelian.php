<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'retur_pembelian'; // Sesuaikan dengan nama tabel Anda
    
    // Set primary key ke no_faktur
    protected $primaryKey = 'no_faktur';
    public $incrementing = false; // non-increment karena bukan integer auto-increment
    protected $keyType = 'string'; // Set tipe key ke string karena no_faktur adalah string

    protected $fillable = [
        'no_faktur',
        'tanggal_retur',
        'kode_supplier',
        'nama_barang',
        'jumlah_dikembalikan',
        'alasan',
        'status'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'no_faktur', 'no_faktur');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }
}


