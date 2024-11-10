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

    // // Menentukan bagaimana menghasilkan no_faktur secara otomatis
    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($transaksi) {
    //         // Format tanggal: YYYYMMDD
    //         $date = Carbon::now()->format('Ymd');
            
    //         // Menghitung jumlah transaksi dengan no_faktur yang diawali dengan INV-YYYYMMDD
    //         $count = TransaksiPenjualan::where('no_faktur', 'like', 'INV-'.$date.'%')->count();
            
    //         // Menyusun no_faktur, dimulai dari INV-YYYYMMDD-001
    //         $transaksi->no_faktur = 'INV-'.$date.'-'.str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    //     });
    // }
}
