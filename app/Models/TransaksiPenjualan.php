<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'transaksi_penjualan';

    // Primary key dari tabel
    protected $primaryKey = 'no_faktur';

    // Menentukan apakah primary key adalah tipe string
    protected $keyType = 'string';

    // Menentukan apakah tabel memiliki timestamp
    public $timestamps = true;

    // Kolom yang bisa diisi
    protected $fillable = ['no_faktur', 'nama_pelanggan', 'tanggal_pemesanan', 'total_harga'];

    // Definisikan relasi ke model PenjualanPerBarang
    public function penjualanPerBarang()
    {
        return $this->hasMany(PenjualanPerBarang::class, 'no_faktur', 'no_faktur');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($transaksi) {
    //         // Pastikan tanggal_pemesanan sudah diisi
    //         if (!empty($transaksi->tanggal_pemesanan)) {
    //             // Format tanggal: YYYYMMDD (misal 20250521)
    //             $date = Carbon::parse($transaksi->tanggal_pemesanan)->format('Ymd');

    //             // Prefix faktur
    //             $prefix = 'FAK-' . $date;

    //             // Hitung jumlah faktur yang sudah dibuat di tanggal itu
    //             $count = self::whereDate('tanggal_pemesanan', $transaksi->tanggal_pemesanan)
    //                 ->where('no_faktur', 'like', $prefix . '%')
    //                 ->count();

    //             // Buat no_faktur, contoh: FAK-20250521-001
    //             $transaksi->no_faktur = $prefix . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    //         }
    //     });
    // }
}
