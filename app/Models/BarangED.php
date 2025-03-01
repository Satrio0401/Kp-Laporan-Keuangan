<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BarangED extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'baranged';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'kode_barang',
        'lot',
        'nama_barang',
        'jumlah_barang',
        'tanggal_kadaluarsa',
        'tanggal_masuk',
    ];

    // Menentukan primary key
    protected $primaryKey = 'kode_barang';

    // Menentukan apakah primary key adalah string
    protected $keyType = 'string';

    // Menentukan apakah kolom timestamps diaktifkan
    public $timestamps = true;

    // Menambahkan atribut status_exp agar bisa dipanggil langsung di Blade
    protected $appends = ['status_exp'];

    // Accessor untuk status expired
    public function getStatusExpAttribute()
    {
        $today = Carbon::now();
        $expDate = Carbon::parse($this->tanggal_kadaluarsa);
        $diffDays = $today->diffInDays($expDate, false);

        if ($diffDays < 0) {
            return '<span class="badge bg-danger">Expired</span>';
        } elseif ($diffDays <= 7) {
            return '<span class="badge bg-warning">Hampir Expired</span>';
        } else {
            return '<span class="badge bg-success">Aman</span>';
        }
    }

    // Event untuk generate lot otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($barangED) {
            // Ambil tanggal yang dimasukkan oleh pengguna
            $tanggalMasuk = Carbon::parse($barangED->tanggal_masuk)->format('Ymd');

            // Cek jumlah data yang sudah ada untuk tanggal tersebut
            $count = BarangED::where('lot', 'like', 'Batch_' . $tanggalMasuk . '%')->count();

            // Generate kode lot dengan menambahkan urutan angka, mulai dari 001
            $barangED->lot = 'Batch_' . $tanggalMasuk . '_' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
